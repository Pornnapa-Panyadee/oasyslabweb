
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
const VueI18n = require('vue-i18n').default;
window.Vue.use(VueI18n);
Vue.use(require('vue-scrollactive'));

Vue.component('home-page', require('./pages/Home/index.vue'));
Vue.component('members-page', require('./pages/Members/index.vue'));
Vue.component('member-page', require('./pages/Member/index.vue'));
Vue.component('publications-page', require('./pages/Publications/index.vue'));
Vue.component('field-page', require('./pages/Field/index.vue'));
Vue.component('article-page', require('./pages/Article/index.vue'));

var messages = require('./locales/index').default

const i18n = new VueI18n({
    locale: localStorage.getItem('locale') || 'th',
    messages
});

const app = new Vue({
    el: '#mainContent',
    i18n
});
