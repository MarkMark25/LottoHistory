import Vue from 'vue';
import vuetify from './vuetify';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
Vue.use(VueAxios, axios);
Vue.use(VueToast);

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('six-fournine', require('./components/LottoSixFourNine/index.vue').default);
Vue.component('lotto-max', require('./components/LottoMax/index.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/**
 * START
 * This line of code disable the vue dev tool.
 * Comment this lines when you are development mode.
 */
//REMOVE THIS COMMENT
// Vue.config.devtools = false
// Vue.config.debug = false
// Vue.config.silent = true

/**
 * END of disable code
 */
const app = new Vue({
	el: '#app',
	vuetify,
});
