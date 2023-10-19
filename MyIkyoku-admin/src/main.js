import Vue from 'vue'
import './plugins/vuetify'
import router from './router'

import BootstrapVue from "bootstrap-vue"

import App from './App'

import Default from './Layout/Wrappers/baseLayout.vue';
import Pages from './Layout/Wrappers/pagesLayout.vue';
import Apps from './Layout/Wrappers/appLayout.vue';

import MultiFiltersPlugin from './plugins/MultiFilters'
import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'

window.toastr = require('toastr');
window.toastr.position = { X: "Right", Y: "Bottom" };
window.toastr.timeDelay = 1000;

Vue.config.productionTip = false;

var filter = function(text, length, clamp){
    clamp = clamp || '...';
    var node = document.createElement('div');
    node.innerHTML = text;
    var content = node.textContent;
    return content.length > length ? content.slice(0, length) + clamp : content;
};

Vue.filter('truncate', filter);

Vue.use(BootstrapVue);
Vue.use(VueToastr2);
Vue.use(MultiFiltersPlugin);

Vue.component('default-layout', Default);
Vue.component('userpages-layout', Pages);
Vue.component('apps-layout', Apps);

new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
});
