require('./bootstrap');

// VUE
window.Vue = require('vue');

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import Vuex from 'vuex'
import store from './store'
Vue.use(Vuex)

const app = new Vue({
    el: '#app',
    data() {
        return {
            template: ''
        }
    },
    methods: {
    	toggleModal() {
    		this.$store.dispatch('toggleModal')
    	}
    },
    store
});


// Nav
let navButton = document.getElementById('nav-button')

navButton.addEventListener('click', function(event) {
	let navDropdown = document.getElementById('nav-dropdown')

	navDropdown.classList.toggle('hidden')
	navDropdown.classList.toggle('text-center')
})

// More info button
const btn = document.getElementById('more-info-button');

if(btn) {
    const scrollToArea = document.getElementById('more-info').offsetTop;

    btn.addEventListener('click', () => window.scrollTo({
        top: scrollToArea,
        behavior: 'smooth',
    }));
}