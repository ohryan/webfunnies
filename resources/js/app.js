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
        }
    },
    mounted () {
        axios
        .get('/api/items')
        .then(response => (
            this.loaded = true,
            this.items = response.data.data,
            this.updateLastRead(response.data.data)
        ));
    },
})


