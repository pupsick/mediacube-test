require('./bootstrap');
require('./includes/messenger');
require('./includes/messenger-theme-future');

window.Messenger.options = {
    extraClasses: 'messenger-fixed messenger-on-bottom messenger-on-right',
    theme: 'air'
};

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

import {routes} from "./routes";

const router = new VueRouter({
    mode: 'history',
    routes
});

Vue.prototype.$messenger = function (message, error = false, hideAfter = 5) {
    let data;
    data = {
        message: message,
        hideAfter: hideAfter,
    };
    data.type = error ? 'error' : '';

    Messenger().post(data);
};

import ContentLayer from './components/Template.vue';

const app = new Vue({
    router,
    el: '#application',
    components: {
        ContentLayer
    },
});
