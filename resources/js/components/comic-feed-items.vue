<template>
    <div id="items-list-container">
        <div class="row item-container" v-for="item in items" v-bind:items=items>
            <div class="item col-12 col-md-6 mx-auto py-5">
                <h3><a :href="item.permalink" target="_blank">{{item.title}}</a></h3>
                <h4><a :href="item.feed.site_url" target="_blank">{{item.feed.name}}</a> &mdash; {{ item.pubDate | moment }}</h4>
                <div class="text-center">
                    <img :src="item.content" :alt="item.title" class="mx-auto pt-3">
                </div>
            </div>
        </div>
    </div>    
</template>

<script>
export default {
    prop: ['items'],
    data() {
        return {

        }
    }
}
</script>
