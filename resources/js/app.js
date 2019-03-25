import Vue from 'vue';

import moment from 'moment'

// import VueRouter from 'vue-router';
// Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

new Vue({
    el: '#app',
    data() {
        return {
            loaded: false,
            items: null,
            newItemCount: 0,
            apiURI: '/api/items',
            page: 1,
            lastPage: 1
        }
    },
    filters: {
        moment: function(date){
            return moment.unix(date).format('MMMM Do YYYY');
        }
    },
    methods: {
        updateLastRead(feedItems) {
            let lastLoaded = localStorage.getItem('lastloaded');
    
            if (lastLoaded !== null) {
                feedItems.forEach(item => {
                    if (item.pubDate > lastLoaded){
                        this.newItemCount++;
                    }
                });
            }

            localStorage.setItem('lastloaded', Math.floor(Date.now() / 1000));
        },
        loadMore() {
            let nextPage = this.page + 1;
            console.log(nextPage, this.page, this.lastPage);
            if (nextPage <= this.lastPage) {
                axios
                .get(this.apiURI + '?page=' + nextPage)
                .then(response => (
                    this.loaded = true,
                    this.items = this.items.concat(response.data.data),
                    this.page = response.data.current_page
                ));
            }
        }
    },
    created () {
        axios
        .get(this.apiURI)
        .then(response => (
            this.loaded = true,
            this.items = response.data.data,
            this.updateLastRead(response.data.data),
            this.currentPage = response.data.current_page,
            this.lastPage = response.data.last_page
        ));
    },
})
