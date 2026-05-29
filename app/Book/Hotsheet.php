<?php

namespace App\Book;

use \DB;
use App\Helpers;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Hotsheet extends Model
{
    protected $connection = 'ctb_data';
    protected $table = 'ctb_hot_sheet';
    protected $fav_table = 'ctb_user_fav';
    public $timestamps = false;

    const PREVIEWED_ARTICLE_COUNT = 3;

    protected $guarded=[];

    //
    protected $hidden = [
        'id',
        'post_id',
        'text',
        'tags',
        'updated',
        'favorite',
	'is_favorite',
    ];


    public function posted_at() {
        return Carbon::parse($this->updated)->toFormattedDateString();
    }

    public function addProps() {
        if (empty($this->text)) return;

	$post_id = $this->post_id;
	$user_id = Auth::user()->id;
	$is_favorite = False;

    	// Check if the entry is a favorite
	$is_favorite = \CTBDB::table('ctb_user_fav')
                            ->where('user_id', $user_id)
                            ->where('page', $post_id)
                            ->where('type', 'hotsheet')
                            ->exists();

        $hs_data = \Cache::rememberForever("hotsheet.$this->id.data", function() {
            $html = Helpers\str_get_html($this->text);
            $preview_img=$title=$outertext='';
            if ($html) {
                $firstChild=$html->firstChild();
                $title = html_entity_decode($firstChild->plaintext, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $firstChild->outertext = '';
                foreach ($html->find('table') as $table) {
                    $table->setAttribute('v-ctb-table', 'test');
                }
    
                if(isset($html->find('img', 0)->src)) {
                    $preview_img = $html->find('img', 0)->src;
                } else {
                    $preview_img = '';
                }
                $outertext=$html->outertext;
            }

		$post_id = $this->post_id;
		$user_id = Auth::user()->id;

		$is_favorite = \CTBDB::table('ctb_user_fav')
                            ->where('user_id', $user_id)
                            ->where('page', $post_id)
                            ->where('type', 'hotsheet')
                            ->exists();

            return [
                'preview_img' => $preview_img,
                'title' => html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                'body' => $outertext,
		'is_favorite' => $is_favorite
            ];



        });

        $this->preview_img = $hs_data['preview_img'];
        $this->title = html_entity_decode($hs_data['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $this->body = $hs_data['body'];
	$this->is_favorite = $is_favorite;

    }

    static public function getTopArticle() {
        $hs = self::orderBy('updated', 'DESC')->first();
        $hs->addProps();
        return $hs;
    }
    static public function getRecentArticle($limit=20) {
        $hs = self::orderBy('updated', 'DESC')->take($limit)
        ->get()
        ->unique('post_id')
        ->map(function ($hs) {
            $hs->addProps();
            return $hs;
        });
        return $hs;
    }
    static public function getArticleByFilter($request) {
        $search = $request->input('search');
        $date = $request->input('date');
        $district = $request->input('district');
        $condidate = $request->input('condidate');
        // if(!$date) return self::getArticleList();

        $query = self::query();

        if ($request->input('date')) {
            $query->whereDate('updated', $date);
        }

        if ($search) {
            $query->where('text', 'LIKE', '%' . $search . '%');
        }

        if ($district) {
            $query->where('text', 'LIKE', '%' . $district . '%');
        }

        if ($condidate) {
            $query->where('text', 'LIKE', '%' . $condidate . '%');
        }

        // $hs = $query->orderBy('updated', 'DESC')->take(100)
        // ->get()
        // ->unique('post_id')
        // ->map(function ($hs) {
        //     $hs->addProps();
        //     return $hs;
        // });


        $articles = $query->orderBy('updated', 'DESC')
        ->groupBy('post_id')
        ->select('post_id', DB::raw('MAX(id) as id'), DB::raw('MAX(text) as text'), DB::raw('MAX(tags) as tags'), DB::raw('MAX(updated) as updated'), \DB::raw('MAX(favorite) as favorite'))
        ->paginate(12);
        $articles->each(function ($article) {
            $article->addProps();
        });
       return $articles;








        return $hs;
    }
    static public function getPreviewedArticles() {
        return self::orderBy('updated', 'DESC')
            ->limit(5)
            ->get()
            ->unique('post_id')
            ->splice(1, 1 + self::PREVIEWED_ARTICLE_COUNT)
            ->map(function ($hs) {
                $hs->addProps();
                return $hs;
            });
    }
    static public function getArticleList($fourcode=null) {
        $currentDate = Carbon::now();
        // Calculate the date 2 years ago
        $twoYearsAgo = $currentDate->subYears(2);

        $query = self::query();
        if ($fourcode) {
            $query->where('text', 'LIKE', '%' . $fourcode . '%');
        }

        $articles = $query->orderBy('updated', 'DESC')
            ->where('updated', '>', $twoYearsAgo)
            ->groupBy('post_id')
            ->select('post_id', DB::raw('MAX(id) as id'), DB::raw('MAX(text) as text'), DB::raw('MAX(tags) as tags'), DB::raw('MAX(updated) as updated'), \DB::raw('MAX(favorite) as favorite'))
            ->paginate(12);
            $articles->each(function ($article) {
                $article->addProps();
            });
           return $articles;
    }
    static public function getArticleByForcode($fourcode) {
        return self::getArticleList($fourcode);

        // return self::orderBy('updated', 'DESC')
        //     ->where('updated', '>', '2021-12-01')
        //     ->where('text', 'LIKE', '%' . $fourcode . '%')
        //     ->groupBy('post_id')
        //     ->select('post_id', DB::raw('MAX(id) as id'), DB::raw('MAX(text) as text'), DB::raw('MAX(tags) as tags'), DB::raw('MAX(updated) as updated'), \DB::raw('MAX(favorite) as favorite'))
        //     ->paginate(15)
        //     // ->unique('post_id')
        //     // ->splice(1 + self::PREVIEWED_ARTICLE_COUNT)
        //     ->map(function ($hs) {
        //         $hs->addProps();
        //         return $hs;
        //     });
    }

static public function getFavoriteArticle() {
    // Retrieve authenticated user ID
    $user_id = Auth::user()->id;

    // Retrieve matching 'page' values from ctb_user_fav table
    $matching_pages = \CTBDB::table('ctb_user_fav')
                            ->where('user_id', $user_id)
                            ->where('type', 'hotsheet')
                            ->pluck('page');

    // Retrieve maximum id for each post_id from self table
    $latest_ids_self = self::select(\DB::raw('MAX(id) as id'))
                            ->whereIn('post_id', $matching_pages)
                            ->groupBy('post_id');

    // Retrieve matching entries from self table using max ids
    $matching_entries = self::whereIn('id', $latest_ids_self)
                            ->orderBy('updated', 'DESC')
                            ->get();

    // Continue with existing logic to map additional properties
    return $matching_entries->map(function ($hs) {
        $hs->addProps();
        return $hs;
    });
}

}
