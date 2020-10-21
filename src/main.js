import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';

import { store } from "./store/cssStore";

Vue.use(VueAxios, axios, VueRouter);

new Vue({
  el: '#app',
  store,
  render: h => h(App)
})
