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