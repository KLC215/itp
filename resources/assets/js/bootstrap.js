// Third party modules
import $ from 'jquery';
import Vue from 'vue';
import axios from 'axios';
import VueEvents from 'vue-events';
import 'bootstrap-sass';
import VueHighlightJS from 'vue-highlightjs';
import VueCodeMirror from 'vue-codemirror'
import VueSweetAlert from 'vue-sweetalert';


// ElementUI modules
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-default/index.css';

// Core helpers
import './core/urls';
import UserStore from './core/userStore';

// Utilites
import Form from './utilities/Form';

// Other modules
import 'emoji-data-css/files/eo-all-emoji.min.css';
import 'animate.css/animate.min.css';
import 'intro.js/introjs.css';

window.$ = window.jQuery = $;

window.Vue = Vue;

Vue.use(ElementUI, {
	locale
});
Vue.use(VueEvents);
Vue.use(UserStore);
Vue.use(VueHighlightJS);
Vue.use(VueCodeMirror);
Vue.use(VueSweetAlert);

window.axios = axios;

window.axios.defaults.headers.common = {
	'X-CSRF-TOKEN': window.Laravel.csrfToken,
	'X-Requested-With': 'XMLHttpRequest'
};

window.Form = Form;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
