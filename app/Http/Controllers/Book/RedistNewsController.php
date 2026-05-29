<?php

namespace App\Http\Controllers\Book;

use App\Book\RedistNews;
use App\Polls\Poll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedistNewsController extends Controller
{

    public function index() {
        return view('book.redist_news', [
            'top_article' => RedistNews::getTopArticle(),
            'secondary_articles' => RedistNews::getPreviewedArticles(),
            'other_articles' => RedistNews::getArticleList(),
            'currentPoll' => Poll::getCurrentPoll(),
        ]);
    }

    public function showArticle($article) {
        $hs = RedistNews::where('post_id', $article)
            ->orderBy('updated', 'desc')
            ->first();
        $hs->addProps();

        return view('book.redist_news_item', [
            'hotsheet' => $hs,
            'recommended_articles' => RedistNews::getRecommendedArticles($article),
        ]);
    }

}
