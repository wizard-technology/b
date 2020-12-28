<?php

namespace App\Http\Controllers;

use App\Article;
use App\Logger;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
   public function save_article(Request $request)
   {
    $article = Article::findOrFail(3);
    $article->ar_article = json_encode($request->article_english_title);
    $article->ar_article_ku = json_encode($request->article_kurdish_title);
    $article->ar_article_ar = json_encode($request->article_arabic_title);
    $article->ar_article_pr = json_encode($request->article_persian_title);
    $article->ar_article_kr = json_encode($request->article_kurmanji_title);
    $article->save();
    $article2 = Article::findOrFail(4);
    $article2->ar_article = json_encode($request->article_english_desc);
    $article2->ar_article_ku = json_encode($request->article_kurdish_desc);
    $article2->ar_article_ar = json_encode($request->article_arabic_desc);
    $article2->ar_article_pr = json_encode($request->article_persian_desc);
    $article2->ar_article_kr = json_encode($request->article_kurmanji_desc);
    $article2->save();
    Logger::create([
        'log_name' => 'Website',
        'log_action' => 'Update',
        'log_admin' => session('dashboard'),
        'log_info' => json_encode('Home Information Updated')
    ]);
    return redirect()->back()->withSuccess('Updated Website Successfully !');
   }
}
