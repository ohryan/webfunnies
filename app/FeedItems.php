<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem as RSSFeedItem;

class FeedItems extends Model implements Feedable
{
    protected $fillable = [
        'feeds_id',
        'title',
        'content',
        'permalink',
        'pubDate',
    ];
    
    public function feed()
    {
        return $this->belongsTo('App\Feeds', 'feeds_id', 'id');
    }

    public function toFeedItem()
    {
        return RSSFeedItem::create([
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->content,
            'updated' => $this->updated_at,
            'link' => $this->permalink,
            'author' => $this->feed->name,
        ]);
    }

    public static function getAllFeedItems()
    {
        return FeedItems::where('title', '<>', null)->orderBy('pubDate', 'desc')->with('feed:id,name,site_url')->get();
    }
}
