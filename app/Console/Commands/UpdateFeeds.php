<?php

namespace App\Console\Commands;

use App\Feeds as CommicFeeds;
use App\FeedItems;
use Carbon\Carbon;
use Feeds;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class UpdateFeeds extends Command
{
    protected $cache_key = 'lastfeedupdated';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feeds:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all the feeds.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $num_updated = 0;
        $last_cache_update = Cache::get($this->cache_key);
        if (!is_null($last_cache_update)) {
            $last_cache_update = Carbon::parse($last_cache_update);
        }

        foreach (CommicFeeds::all() as $feed) {

            $forced_new_feed = $feed->created_at->greaterThan($last_cache_update);

            $feed_res = Feeds::make($feed->url, 10);
         
            foreach ($feed_res->get_items() as $item) {
                $item_gmtdate = $item->get_gmdate();
                $item_date = Carbon::parse($item_gmtdate);

                // $forced_new_feed = it's a new feed, grab all the entries.
                // $last_cache_update = the cache update is null, we're probably refreshing the db.
                // else it's a new item!
                if ($forced_new_feed
                    || $last_cache_update === null
                    || $item_date->greaterThan($last_cache_update)
                ) {
                    $img = $this->findComicImage($item, $feed->parse_rule);

                    if (!empty($img)) {
                        $new_item = new FeedItems(
                            [
                                'feeds_id'  => $feed->id,
                                'title'     => Str::limit($item->get_title(), 255),
                                'content'   => $img,
                                'permalink' => $item->get_permalink(),
                                'pubDate'   => strtotime($item->get_gmdate()),
                            ]
                        );
                        $feed->items()->save($new_item);
                        $num_updated++;
                    }
                }
            }
        }

        Cache::set($this->cache_key, now());
        $this->info(sprintf("%d items updated", $num_updated));
    }

    /**
     * Find the image in the feed based on a parse rule
     * 
     * @return string image url
     */
    private function findComicImage(\SimplePie_Item $feed_item, $rule = 'description'): string
    {
        switch($rule) {
            case 'enclosure':
                $enc = $feed_item->get_enclosure();
                return $enc->get_link();
                break;
            case 'content':
                return $this->parseImgSrc($feed_item->get_content());
                break;
            default:
                return $this->parseImgSrc($feed_item->get_description());
        }
    }

    /**
     * Return the first image in the html string.
     * 
     * @return string image
     */
    private function parseImgSrc($html)
    {
        
        preg_match_all('/src="([^"]+)"/', $html, $img, PREG_SET_ORDER);
        return (isset($img[0][1])) ? str_replace('http://', 'https://', $img[0][1]) : '';
    }
}
