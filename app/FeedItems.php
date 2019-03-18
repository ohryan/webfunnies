<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedItems extends Model
{
    protected $fillable = [
        'title',
        'content',
        'permalink',
        'pubDate',
    ];
    
    public function feed()
    {
        return $this->belongsTo('App\Feeds', 'feeds_id');
    }
}
