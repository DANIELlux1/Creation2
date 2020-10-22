import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';

Vue.use(VueAxios, axios, VueRouter);

new Vue({
  el: '#app',
  render: h => h(App)
})
