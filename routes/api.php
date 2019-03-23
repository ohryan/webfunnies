<?php

use Illuminate\Http\Request;

Route::get('/items', function () {
        $feed_items = \App\FeedItems::orderBy('pubDate', 'desc')
            ->with('feed:id,name,site_url')
            ->paginate(10);
        return $feed_items->toJson();
    
})->middleware('api');
