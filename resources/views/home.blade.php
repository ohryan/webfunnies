<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WebFunnies.online</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        @include('feed::links')
    </head>
    <body>
        <header class="py-2">
            <h1 id="main-title">Web Funnies</h1>
            <p class="text-center">Comics <a href="http://twitter.com/ohryan" target="_blank">@ohryan</a> enjoys. <a href="/feed"><img src="{{asset('img/feed-icon.svg')}}" id="rss-icon"></a></p>
        </header>
        <div id="app" class="container-fluid" v-cloak>
            <div id="new-comics-msg-container" class="my-1" v-if="newItemCount > 0">
                <div id="new-comics-msg" class="col-12 col-md-6 mx-auto mt-4 py-2 text-center">
                🔔 @{{newItemCount}} new funnies since the last time you were here! 🔔
                </div>
            </div>
            <div id="items-list-container">
                <div class="row item-container" v-for="(item, index) in items">
                    <div class="item col-12 col-md-6 mx-auto py-5">
                        <h3><a :href="item.permalink" target="_blank">@{{ item.title}}</a></h3>
                        <h4><a :href="item.feed.site_url" target="_blank">@{{item.feed.name}}</a> &mdash; @{{ item.pubDate | moment }}</h4>
                        <div class="text-center">
                            <img :src="item.content" :alt="item.title" class="mx-auto pt-3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mx-auto my-3">
                <button class="btn btn-outline-dark btn-lg" v-on:click="loadMore" v-if="page < lastPage">Show moar!</button>
            </div>
        </div>
        <footer class="mt-3 py-3 text-center">
            <small>All copyright belongs to the original creators.</small>
        </footer>
         <script>
           window.Laravel = <?php echo json_encode([
               'csrfToken' => csrf_token(),
                    ]); ?>
          </script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>