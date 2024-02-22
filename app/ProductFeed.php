<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Feed;

class ProductFeed extends Model implements Feedable
{
   
    public function toFeedItem(): FeedItem
    {
        return new FeedItem([
            'id' =>'1',
            'title' => 'product 1',
            'description' => 'descripton of product 1',
            'link' => 'https://example.com/products/1',
            'author' => 'John Doe',
            'category' => 'category 1',

            'image' => 'https://example.com/products/1/image.jpg',
            'updated' => Carbon::now(),
            'created' => Carbon::now(),
        ]);
    }
    public static function getFeedItems()
    {
        return static::all()->map(function ($product) {
            return $product->toFeedItem();
        });
    }

    public static function getFeed($type)
    {
        $feed = Feed::feed($type)
            ->title('My Products')
            ->description('A feed of my products')
            ->link('https://example.com/products')
            ->language('en-US')
            ->ttl(60)
            ->pubdate(static::latest()->first()->created_at)
            ->generator('My Laravel App')
            ->items(static::getFeedItems())
            ->view('feed.' . $type);

        return $feed;
    }

    public static function createFeed($type)
    {
        $feed = static::getFeed($type);

        $feedPath = storage_path('app/products/feed.' . $type);
        $feed->create($feedPath);
    }
}
