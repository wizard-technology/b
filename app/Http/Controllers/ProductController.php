<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Grouped;
use App\Imageproduct;
use App\Logger;
use App\Product;
use App\Producttag;
use App\Subcategory;
use App\Tag;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->search == 'search') {
            $data = Product::query();
            if (isset($request->category)) {
                $data->where('p_type', $request->category);
                // dd(1);
            }
            if (isset($request->subcategory)) {
                $data->where('p_subcategory', $request->subcategory);
                // dd(2);

            }
            if (isset($request->grouped)) {
                $data->where('p_grouped', $request->grouped);
                // dd(3);

            }
            if (isset($request->priority)) {
                $data->where('p_order_by', $request->priority);
                // dd(4);

            }
            if (isset($request->min)) {
                $data->where('p_price', '>=', $request->min);
                // dd(5);
            }
            if (isset($request->max)) {
                $data->where('p_price', '<=', $request->max);
                // dd(6);
            }
            // if (isset($request->tag)) {
            //     $data->where('p_price', '<=', $request->max);
            //     // dd(6);
            // }
            if (isset($request->hasinfo)) {
                $data->where('p_has_info', 1);
            } else {
                $data->where('p_has_info', 0);
            }
            if (isset($request->state)) {
                $data->where('p_state', 1);
            } else {
                $data->where('p_state', 0);
            }
            $data = $data->with(['tags.tagName', 'type', 'subcategory', 'grouped'])->orderBy('id', 'DESC')->get();
        } else {
            $data = Product::orderBy('id', 'DESC')->get();
        }
        $type = Type::where('t_state', 1)->get();
        $tag = Tag::where('tg_state', 1)->get();
        return view('pages.product.index', [
            'data' => $data,
            'types' => $type,
            'tags' => $tag
        ]);
    }
    public function getSub(Request $request)
    {
        $request->validate([
            'category' => 'required|exists:types,id',
        ]);

        $subcategory = Subcategory::where('st_state', 1)->where('st_type', $request->category)->get();
        return response()->json($subcategory, 200);
    }
    public function getGr(Request $request)
    {
        $request->validate([
            'subcategory' => 'required|exists:subcategories,id',
        ]);
        $grouped = Grouped::where('gr_state', 1)->where('gr_subcategory',  $request->subcategory)->get();
        return response()->json($grouped, 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = Type::where('t_state', 1)->get();
        $tag = Tag::where('t_state', 1)->get();
        $subcategory = Subcategory::where('st_state', 1)->get();
        return response()->json([
            'data' => [
                'types' => $type,
                'tags' => $tag,
                'subcategories' => $subcategory,
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'price' => 'required|numeric|gte:0',
            'info' => 'required|string',
            'info_kurdish' => 'required|string',
            'info_arabic' => 'required|string',
            'info_persian' => 'required|string',
            'info_kurmanji' => 'required|string',
            'category' => 'required|exists:types,id',
            'subcategory' => 'required|exists:subcategories,id',
            'grouped' => 'required|exists:groupeds,id',
            'tag.*' => 'exists:tags,id',
            'tag' => 'array',
            'priority' => 'required|in:1,2,3,4,5',
            'imgs' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:on,null',
            'hasinfo' => 'sometimes|in:on,null',

        ]);
        $product = new Product;
        $product->p_name = $request->name;
        $product->p_name_ku = $request->name_kurdish;
        $product->p_name_ar = $request->name_arabic;
        $product->p_name_pr = $request->name_persian;
        $product->p_name_kr = $request->name_kurmanji;
        $product->p_price = $request->price;
        $product->p_info = $request->info;
        $product->p_info_ku = $request->info_kurdish;
        $product->p_info_ar = $request->info_arabic;
        $product->p_info_pr = $request->info_persian;
        $product->p_info_kr = $request->info_kurmanji;
        $product->p_type = $request->category;
        $product->p_subcategory = $request->subcategory;
        $product->p_grouped = $request->grouped;
        $product->p_order_by = $request->priority;
        $product->p_image = $request->imgs->store('uploads', 'public');
        $product->p_state =  $request->state == 'on' ? 1 : 0;
        $product->p_has_info =  $request->hasinfo == 'on' ? 1 : 0;
        $product->p_admin = session('dashboard');
        $product->save();
        foreach ($request->tag as $key => $value) {
            $productTag = new Producttag;
            $productTag->pt_product = $product->id;
            $productTag->pt_tag =  $value;
            $productTag->pt_admin = session('dashboard');
            $productTag->save();
        }
        Logger::create([
            'log_name' => 'Product',
            'log_action' => 'Create',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($product->with('tags')->orderBy('id', 'DESC')->first()->toArray())
        ]);
        return redirect()->back()->withSuccess('Added Product Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('extra')->findOrFail($id);
        return view('pages.product.show', [
            'data' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $isState = $product->p_state;
        $product->p_state = !$product->p_state;
        $product->save();
        $cart = Cart::with('product')->where('c_product', $product->id)->where('c_state', 0)->delete();
        Logger::create([
            'log_name' => 'Product',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($product->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Product Successfully !');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //'iamge' => 'regex:/^data:image\/(?:gif|png|jpeg|bmp|webp)(?:;charset=utf-8)?;base64,(?:[A-Za-z0-9]|[+/])+={0,2}/g|sometimes',
        $request->validate([
            'name' => 'required|string|max:255',
            'name_kurdish' => 'required|string|max:255',
            'name_arabic' => 'required|string|max:255',
            'name_persian' => 'required|string|max:255',
            'name_kurmanji' => 'required|string|max:255',
            'price' => 'required|numeric|gte:0',
            'info' => 'required|string',
            'info_kurdish' => 'required|string',
            'info_arabic' => 'required|string',
            'info_persian' => 'required|string',
            'info_kurmanji' => 'required|string',
            'category' => 'required|exists:types,id',
            'subcategory' => 'required|exists:subcategories,id',
            'grouped' => 'required|exists:groupeds,id',
            'tag.*' => 'exists:tags,id',
            'tag' => 'array',
            'priority' => 'required|in:1,2,3,4,5',
            'imgs' => 'image|mimes:jpeg,png,jpg,gif|max:8192',
            'state' => 'sometimes|in:on,null',
            'hasinfo' => 'sometimes|in:on,null',
        ]);

        $product = Product::with('tags')->findOrFail($id);
        $product->p_name = $request->name;
        $product->p_name_ku = $request->name_kurdish;
        $product->p_name_ar = $request->name_arabic;
        $product->p_name_pr = $request->name_persian;
        $product->p_name_kr = $request->name_kurmanji;
        $product->p_price = $request->price;
        $product->p_info = $request->info;
        $product->p_info_ku = $request->info_kurdish;
        $product->p_info_ar = $request->info_arabic;
        $product->p_info_pr = $request->info_persian;
        $product->p_info_kr = $request->info_kurmanji;
        $product->p_type = $request->category;
        $product->p_subcategory = $request->subcategory;
        $product->p_grouped = $request->grouped;
        $isState = $product->p_state;
        $isCard = $product->p_has_info;
        $product->p_state =  $request->state == 'on' ? 1 : 0;
        $product->p_has_info =  $request->hasinfo == 'on' ? 1 : 0;
        $product->p_order_by = $request->priority;
        $path = $request->imgs == null ? null :  $product->p_image;
        $product->p_image = isset($request->imgs)  ? $request->imgs->store('uploads', 'public') : $product->p_image;
        $product->save();
        $cart = Cart::with('product')->where('c_product', $product->id)->where('c_state', 0)->get();
        foreach ($cart as $key => $value) {
            // dd($isCard != $value->product->p_has_info);
            if (($isCard != $value->product->p_has_info) || ($isState != $value->product->p_state)) {
                $value->delete();
            } else {
                $value->c_price = $product->p_price;
                $value->c_price_all = $product->p_price * $value->c_amount;
                $value->save();
            }
        }
        // dd($cart);
        if (isset($path)) {
            Storage::delete('public/' . $path);
        }
        Producttag::where('pt_product', $product->id)->delete();
        foreach ($request->tag as $key => $value) {
            $productTag = new Producttag;
            $productTag->pt_product = $product->id;
            $productTag->pt_tag =  $value;
            $productTag->pt_admin = session('dashboard');
            $productTag->save();
        }
        Logger::create([
            'log_name' => 'Product',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($product->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Product Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::with('cart')->findOrFail($id);
        if (count($product->cart) == 0) {
            try {
                Storage::delete('public/' . $product->p_image);
                Producttag::where('pt_product', $product->id)->delete();
                $product->delete();
                Logger::create([
                    'log_name' => 'Product',
                    'log_action' => 'Delete',
                    'log_admin' => session('dashboard'),
                    'log_info' => json_encode($product->toArray())
                ]);
                return redirect()->back()->withSuccess('Deleted Product Successfully !');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->withErrors('Maybe has relation !');
            }
        }
        return redirect()->back()->withErrors('You can not delete this product !');
    }
    public function extra_image(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:8192',
        ]);
        $extra = new Imageproduct;
        $extra->i_link = $request->file->store('uploads', 'public');
        $extra->i_product = $id;
        $extra->i_admin = session('dashboard');
        $extra->save();
        Logger::create([
            'log_name' => 'Product',
            'log_action' => 'Added Extra Image',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($extra->toArray())
        ]);
    }
    public function extra_delete(Request $request, $id)
    {
        $image = Imageproduct::findOrFail($id);
        Storage::delete('public/' . $image->i_link);
        $image->delete();
        Logger::create([
            'log_name' => 'Product',
            'log_action' => 'Deleted Extra Image',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($image->toArray())
        ]);
        return redirect()->back()->withSuccess('Deleted Extra Image Successfully !');
    }
}
