<?php

namespace App\Http\Controllers\Book;

use App\Book\Hotsheet;
use App\Http\Controllers\Controller;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use PDF;

class HotsheetController extends Controller
{

    public function index() {
        // return view('book.hotsheets', [
        //         'top_article' => Hotsheet::getTopArticle(),
        //         'recent_article' => Hotsheet::getRecentArticle(),
        //         'secondary_articles' => Hotsheet::getPreviewedArticles(),
        //         'other_articles' => Hotsheet::getArticleList(),
        //         'currentPoll' => Poll::getCurrentPoll(),
        // ]);
        return view('book.hotsheets', [
                'favorite_article' => Hotsheet::getFavoriteArticle(),
                'other_articles' => Hotsheet::getArticleList(),
        ]);

        // return view('book.hotsheets', [
        //     'top_article' => [],
        //     'secondary_articles' => [],
        //     'recent_article' => [],
        //     'other_articles' => [],
        // ]);

    }

public function favorite(Request $request) {
    $hs = Hotsheet::where('id', $request->id)
                  ->where('post_id', $request->post_id)
                  ->first();

    $user_id = \Auth::user()->id;  
    $post_id = $request->post_id;

    // Check if entry exists in ctb_user_fav table
    $fav_status = \CTBDB::table('ctb_user_fav')
                        ->where('user_id', $user_id)
                        ->where('page', $post_id)
                        ->first();

    // Toggle favorite status based on existence of entry
    if ($fav_status) {
        // Entry exists, delete it
        \CTBDB::table('ctb_user_fav')
               ->where('user_id', $user_id)
               ->where('page', $post_id)
               ->delete();
        $fav = false;
    } else {
        // Entry does not exist, create it
        \CTBDB::table('ctb_user_fav')->insert([
            'user_id' => $user_id,
            'type' => 'hotsheet',
            'page' => $post_id
        ]);
        $fav = true;
    }
    return response()->json(['favorite' => $fav]);
}
    public function filterArticles(Request $request) {

        return view('book.articaleList', [
            'other_articles' => Hotsheet::getArticleByFilter($request),
        ]);

    }

    public function showArticle($article) {
        $hotsheet=$this->getHotsheet($article);
        $previousHsID = $nextHsID = null;
        if ($hotsheet) {
            // Get the ID of the next record
            $nextHs = Hotsheet::where('post_id', '>', $hotsheet->post_id)
                // ->orderBy('post_id', 'asc')
                ->first();
            $previousHs = Hotsheet::where('post_id', '<', $hotsheet->post_id)
                // ->orderBy('post_id', 'desc')
                ->first();

            $nextHsID = $nextHs ? $nextHs->post_id : null;
            $previousHsID = $previousHs ? $previousHs->post_id : null;
        }



        return view('book.hotsheet', [
            'hotsheet' => $hotsheet,
            'next' =>  $nextHsID,
            'prev' =>  $previousHsID,
            'favorite_article' => Hotsheet::getFavoriteArticle(),
        ]);
    }

    public function generatePDF($article)
    {
        $hotsheet=$this->getHotsheet($article);
        $pdf = PDF::loadView('book.hotsheetPdf', ['hotsheet' => $hotsheet])->setOptions(['defaultFont' => 'sans-serif','isRemoteEnabled'=> true]);
        return $pdf->download($hotsheet->title . '.pdf');
    }

    private function getHotsheet($article){
        $hs = Hotsheet::where('post_id', $article)
        ->orderBy('updated', 'desc')
        ->first();
        $hs->addProps();

        $body = new DOMDocument();
        @$body->loadHTML($hs->body);

        $xpath = new DOMXPath($body);
        foreach ($xpath->query("//img") as $imageNode) {
            $oldSrc = $imageNode->getAttribute('src');
            $newSrc = 'https://californiatargetbook.com' . $oldSrc;
            $imageNode->setAttribute('src', $newSrc);
            $imageNode->setAttribute('alt', $newSrc);
        }
        $hs->body = $body->saveHTML();
        return $hs;
    }

}
