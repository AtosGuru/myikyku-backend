<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use Feeds;

class ArticleController extends Controller
{
    public function getNewsArticles()
    {
        $feeds = [
            Feeds::make(['https://www.cbnews.jp/rss/news.xml'], 10, true),
            Feeds::make('http://healthdayjapan.com/feed/')
        ];

        $items = [];
        foreach ($feeds as $feed) {
            foreach ($feed->get_items() as $item) {
                $categories = [];
                foreach ($item->get_categories() as $category) {
                    $categories[] = $category->get_label();
                }
                $items[] = [
                    'title' => $item->get_title(),
                    'thumbnail' => $item->get_description(),
                    'categories' => $categories,
                    'contents' => $item->get_content(),
                    'author' => $item->get_author(),
                    'pubDate' => $item->get_date('Y/m/d'),
                    'link' => $item->get_permalink(),
                    'guid' => $item->get_id(),
                ];
            }
        }

        return $items;
    }

    public function getNewsArticlesByCategory()
    {
        $feeds = [
            Feeds::make(['https://www.cbnews.jp/rss/news.xml'], 10, true),
            Feeds::make('http://healthdayjapan.com/feed/')
        ];

        $items = [];
        foreach ($feeds as $feed) {
            foreach ($feed->get_items() as $item) {
                $categories = [];
                foreach ($item->get_categories() as $category) {
                    $categories[] = $category->get_label();
                }
                $items[] = [
                    'title' => $item->get_title(),
                    'thumbnail' => $item->get_description(),
                    'categories' => $categories,
                    'contents' => $item->get_content(),
                    'author' => $item->get_author(),
                    'pubDate' => $item->get_date('Y/m/d'),
                    'link' => $item->get_permalink(),
                    'guid' => $item->get_id(),
                ];
            }
        }

        return $items;
    }

    public function getClipArticles()
    {
        $feeds = [
            Feeds::make(['https://www.cbnews.jp/rss/news.xml'], 10, true),
            Feeds::make('http://healthdayjapan.com/feed/')
        ];

        $items = [];
        foreach ($feeds as $feed) {
            foreach ($feed->get_items() as $item) {
                $categories = [];
                foreach ($item->get_categories() as $category) {
                    $categories[] = $category->get_label();
                }
                $items[] = [
                    'title' => $item->get_title(),
                    'thumbnail' => $item->get_description(),
                    'categories' => $categories,
                    'contents' => $item->get_content(),
                    'author' => $item->get_author(),
                    'pubDate' => $item->get_date('Y/m/d'),
                    'link' => $item->get_permalink(),
                    'guid' => $item->get_id(),
                ];
            }
        }

        return $items;
    }
}
