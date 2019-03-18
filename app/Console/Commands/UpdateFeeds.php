<?php

namespace App\Console\Commands;

use App\Feeds as CommicFeeds;
use App\FeedItems;
use Carbon\Carbon;
use Feeds;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

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

        foreach(CommicFeeds::all() as $feed){
            
            $feed_res = Feeds::make($feed->url, 3);
         
            foreach($feed_res->get_items() as $item) {
                $item_date = Carbon::parse($item->get_date());

                if ($last_cache_update === null || $item_date->greaterThan($last_cache_update)) {
                    $img = $this->findComicImage($item, $feed->parse_rule);

                    if (!empty($img)) {
                        $new_item = new FeedItems(
                            [
                                'feeds_id' => $feed->id,
                                'title'     => $item->get_title(),
                                'content'   => $img,
                                'permalink' => $item->get_permalink(),
                                'pubDate'   => $item->get_date('U'),
                            ]
                        );
                        $feed->items()->save($new_item);
                        $num_updated++;
                    }
                }
            }
        }

        Cache::set($this->cache_key, now());
        $this->info(sprintf("%d items updated",$num_updated));
    }

    private function findComicImage(\SimplePie_Item $feed_item, $rule = 'description')
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

    private function parseImgSrc($html)
    {
        preg_match('/\<img.+src\=(?:\"|\')(.+?)(?:\"|\')[^>](?:.+?)\>/', $html, $img);

        return $img[1] ?? '';
    }
}
