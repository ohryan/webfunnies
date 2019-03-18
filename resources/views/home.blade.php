<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>WebFunnies.online</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1 id="main-title">Web Funnies</h1>
        <div id="app" class="container-fluid" v-cloak>
            <div v-if="!loaded">Loading&hellip;</div>
            <div id="items-list-container" v-else>
                <div class="row item-container" v-for="item in items">
                    <div class="item col-12 col-md-6 mx-auto py-5">
                        <h3><a :href="item.permalink" target="_blank">@{{ item.title}}</a></h3>
                        <h4><a :href="item.feed.site_url" target="_blank">@{{item.feed.name}}</a> &mdash; @{{ item.pubDate | moment }}</h4>
                        <div class="text-center">
                            <img :src="item.content" :alt="item.title" class="mx-auto pt-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="my-3 pt-3 text-center">
            <p>&</p>
            <p>Simply a feed of comics <a href="http://twitter.com/ohryan" target="_blank">@ohryan</a> enjoys.</p>
        </footer>
         <script>
           window.Laravel = <?php echo json_encode([
               'csrfToken' => csrf_token(),
                    ]); ?>
          </script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>