<?php

namespace App\Book;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

use App\Helpers;

class RedistNews extends Model
{
    protected $connection = 'ctb_data';
    protected $table = 'ctb_newsfeed';

    const PREVIEWED_ARTICLE_COUNT = 3;

    //
    protected $hidden = [
        'id',
        'post_id',
        'post_text',
        'post_headline',
	'post_url',
        'updated',
    ];


    public function posted_at() {
        return Carbon::parse($this->updated)->toFormattedDateString();
    }

    public function addProps() {
        if (empty($this->post_text)) return;

        $hs_data = \Cache::remember("redist_news.$this->id.data", 5, function() {
            $html = Helpers\str_get_html($this->post_text);

            $title = $this->post_headline;
	    $url   = $this->post_url;
	    $body =  $this->post_text;

	    if(!$title) {
		$title = "Article";
	    }

	    //$display_title = "<a href='$url' target='_blank'>$title</a>";

            $html->firstChild()->outertext = '';

            foreach ($html->find('table') as $table) {
                $table->setAttribute('v-ctb-table', 'test');
            }

            $preview_img = $html->find('img', 0)->src;

            return [
                'preview_img' => $preview_img,
                'title' => $title,
		'url'	=> $url,
                'body' => $body,
            ];
        });

        $this->preview_img = $hs_data['preview_img'];
        $this->title = $hs_data['title'];
        $this->body = $hs_data['body'];
    }

    static public function getTopArticle() {
        $hs = self::orderBy('updated', 'DESC')->first();
        $hs->addProps();
        return $hs;
    }
    static public function getPreviewedArticles() {
        return self::orderBy('updated', 'DESC')
            ->limit(8)
            ->get()
            ->unique('post_id')
            ->splice(1, 1 + self::PREVIEWED_ARTICLE_COUNT)
            ->map(function ($hs) {
                $hs->addProps();
                return $hs;
            });
    }
    static public function getArticleList() {
        return self::orderBy('updated', 'DESC')
            ->get()
            ->unique('post_id')
            ->splice(1 + self::PREVIEWED_ARTICLE_COUNT)
            ->map(function ($hs) {
                $hs->addProps();
                return $hs;
            });
    }
    static public function getRecommendedArticles($article) {
        return self::orderBy('updated', 'DESC')
            ->whereNotIn('post_id', [$article])
            ->limit(4)
            ->get()
            ->unique('post_id')
            ->map(function ($hs) {
                $hs->addProps();
                return $hs;
            });
    }

}
