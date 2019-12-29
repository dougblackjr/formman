import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
		forms: [],
		total_forms: 0,
		total_responses: 0,
		total_spam: 0,
		total_recent: 0,
		showModal: false
	},
	getters: {
		forms: state => state.forms,
		total_forms: state => state.total_forms,
		total_responses: state => state.total_responses,
		total_spam: state => state.total_spam,
		total_recent: state => state.total_recent,
		showModal: state => state.showModal
	},
	mutations: {
		setForms(state, forms) {
			state.forms = forms
		},
		setTotalForms(state, total_forms) {
			state.total_forms = total_forms
		},
		setTotalResponses(state, total_responses) {
			state.total_responses = total_responses
		},
		setTotalSpam(state, total_spam) {
			state.total_spam = total_spam
		},
		setTotalRecent(state, total_recent) {
			state.total_recent = total_recent
		},
		setShowModal(state, showModal) {
			state.showModal = showModal
		}
	},
	actions: {
		getForms(context) {

			window.axios.get('/form')
			.then((response) => {

				const data = response.data

				context.commit('setForms', data.forms)
				context.commit('setTotalForms', data.total_forms)
				context.commit('setTotalResponses', data.total_responses)
				context.commit('setTotalSpam', data.total_spam)
				context.commit('setTotalRecent', data.total_recent)
			})

		},
		toggleModal(context) {
			const body = document.querySelector('body')
			context.state.showModal = !context.state.showModal
			body.classList.toggle('modal-active')
		}
	}
})


export default store