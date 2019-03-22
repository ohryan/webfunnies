<?php
/**
 * Feeds Model
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Feeds Model.
 */
class Feeds extends Model
{
    protected $fillable = [
        'name',
        'url',
        'site_url',
        'skip_ssl'
    ];

    /**
     * Get the feed's items.
     * 
     * @return FeedItems
     */
    public function items() 
    {
        return $this->hasMany('App\FeedItems', 'id', 'feeds_id');
    }
}
