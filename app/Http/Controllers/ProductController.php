<?php

namespace App\Http\Controllers;

use App\Grouped;
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
    public function index()
    {
        $data = Product::with(['tags.tagName', 'type', 'subcategory', 'grouped'])->orderBy('id', 'DESC')->get();
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
    public function show(Product $product)
    {
        $product = $product->with('tags')->first();
        if (is_null($product)) return response()->json([
            'message' => 'Product not found',
            'errors' => [
                'product' => 'Wrong id'
            ]
        ], 404);
        return response()->json([
            'product' => $product
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->p_state = !$product->p_state;
        $product->save();
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
        $product->p_state =  $request->state == 'on' ? 1 : 0;
        $product->p_has_info =  $request->hasinfo == 'on' ? 1 : 0;
        $product->p_order_by = $request->priority;
        $path = $request->imgs == null ? null :  $product->p_image;
        $product->p_image = isset($request->imgs)  ? $request->imgs->store('uploads', 'public')     : $product->p_image;
        $product->save();
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
}
