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
            items: null
        }
    },
    filters: {
        moment: function(date){
            return moment.unix(date).format('MMMM Do YYYY');
        }
    },
    mounted () {
        axios
        .get('/api/items')
        .then(response => (
            this.loaded = true,
            this.items = response.data.data
        ))
    }
})


