import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        styles: [],
        test: "Does this work?"
    },
    getters: {
        value: state => {
            return state.test;
        }
    },
    actions: {
        
    }
})