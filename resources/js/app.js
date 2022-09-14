require('./bootstrap');
  
import Vue from 'vue'
  
Vue.component('multiple-image-component', require('./components/MultipleImageUploadComponent.vue').default);

const app = new Vue({
    el: '#app'
});