<?php

namespace App\Http\Controllers;

use App\Article;
use App\Logger;
use App\Setting;
use Illuminate\Http\Request;
use DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Article::count() == 0) {
            DB::table('articles')->insert([[
                'id' => 1,
                'ar_article' => json_encode('Write Some Things Here'),
                'ar_article_ku' => json_encode('لێرە شتێک بنووسە'),
                'ar_article_ar' => json_encode('اكتب بعض الأشياء هنا'),
                'ar_article_pr' => json_encode('برخی موارد را در اینجا بنویسید'),
                'ar_article_kr' => json_encode('Li vir Hin Tiştan Binivîse'),
                'ar_admin' => session('dashboard'),
                'ar_type' => 'term',
            ], [
                'id' => 2,
                'ar_article' => json_encode('Write Some Things Here'),
                'ar_article_ku' => json_encode('لێرە شتێک بنووسە'),
                'ar_article_ar' => json_encode('اكتب بعض الأشياء هنا'),
                'ar_article_pr' => json_encode('برخی موارد را در اینجا بنویسید'),
                'ar_article_kr' => json_encode('Li vir Hin Tiştan Binivîse'),
                'ar_admin' => session('dashboard'),
                'ar_type' => 'privacy',
            ]]);
        }
        $article = Article::get();
        $setting = Setting::first();
        $logger = Logger::with('employee')->orderBy('created_at', 'DESC')->get();
        return view('pages.dashboard.setting', ['setting' => $setting, 'logger' => $logger, 'article' => $article]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'bizzcoin' => 'required|numeric',
            'message' => 'required|min:5|max:255',
            'forget' => 'required|min:5|max:255',
            'state' => 'sometimes|in:on,null',
        ]);
        $setting = Setting::findOrFail($id);
        $setting->bizzcoin = $request->bizzcoin;
        $setting->message = $request->message;
        $setting->forget = $request->forget;
        $setting->state_app = $request->state == 'on' ? 1 : 0;
        $setting->save();
        Logger::create([
            'log_name' => 'Setting',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($setting->toArray())
        ]);
        return redirect()->back()->withSuccess('Updated Setting Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $logger = Logger::findOrFail($id);
        $logger->log_state = 0;
        $logger->save();
    }
    public function more(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->ar_article = json_encode($request->article_english);
        $article->ar_article_ku = json_encode($request->article_kurdish);
        $article->ar_article_ar = json_encode($request->article_arabic);
        $article->ar_article_pr = json_encode($request->article_persian);
        $article->ar_article_kr = json_encode($request->article_kurmanji);
        $article->save();
        Logger::create([
            'log_name' => 'Setting',
            'log_action' => 'Update',
            'log_admin' => session('dashboard'),
            'log_info' => json_encode($id == 1 ? 'Terms And Condition Updated': 'Privacy Policy Updated')
        ]);
        return redirect()->back()->withSuccess('Updated Setting Successfully !');
    }
}
