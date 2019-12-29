<template>
	<div>
		<div class="flex flex-wrap -mx-4 mb-8">
		    <div class="w-full md:w-1/3 px-4 mb-6 lg:mb-0">
		        <div class="h-full">
		            <div class="text-center p-4 mb-2 bg-blue-500 text-white rounded">
		                <h3 class="text-3xl leading-tight font-heading font-semibold">{{ formInfo.responses_count }}</h3><span class="leading-none">Total Responses</span></div>
		        </div>
		    </div>
		    <div class="w-full md:w-1/3 px-4 mb-6 lg:mb-0">
		        <div class="h-full">
		            <div class="text-center p-4 mb-2 bg-red-500 text-white rounded">
		                <h3 class="text-3xl leading-tight font-heading font-semibold">{{ formInfo.recent_count }}</h3><span class="leading-none">Last 24 Hours </span></div>
		        </div>
		    </div>
		    <div class="w-full md:w-1/3 px-4 mb-6 lg:mb-0">
		        <div class="h-full">
		            <div class="text-center p-4 mb-2 bg-green-500 text-white rounded">
		                <h3 class="text-3xl leading-tight font-heading font-semibold">{{ formInfo.spam_count }}</h3><span class="leading-none">Total Spam</span></div>
		        </div>
		    </div>
		</div>
		<table class="w-full table-auto">
		    <thead>
		        <tr>
		            <th class="border-t px-2 py-2" scope="col">Date</th>
		            <th class="border-t px-2 py-2" scope="col">From</th>
		            <th class="border-t px-2 py-2" scope="col">Data</th>
		            <th class="text-center border-t px-2 py-2" scope="col">Status</th>
		            <th class="text-center border-t px-2 py-2" scope="col">Actions</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr v-for="r in responses" :key="r.id">
		            <td class="border-t px-2 py-2">{{ getDate(r) }}</td>
		            <td class="border-t px-2 py-2">{{ getFrom(r) }}</td>
		            <td class="border-t px-2 py-2" v-html="getData(r)"></td>
		            <td class="text-center border-t px-2 py-2">
		            	<span class="inline-block text-sm py-1 px-3 rounded-full text-white" :class="getStatusClass(r)">
			            	{{ getStatus(r) }}
			            </span>
		            </td>
		            <td class="text-center border-t px-2 py-2 flex flex-row">
		            	<button v-on:click="archive(r)" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center text-xs w-half">
							<span>Archive</span>
		            	</button>
    	            	<button v-on:click="deleteResponse(r)" class="bg-red-700 hover:bg-red-900 text-white font-bold py-2 px-4 rounded inline-flex items-center text-xs w-half">
    						<span>Delete</span>
    	            	</button>
		            </td>
		        </tr>
		    </tbody>
		</table>
	</div>
</template>

<script>
	export default {
		components: {},
		props: {
			form: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
				formInfo: this.form,
				responses: this.form.responses
			}
		},
		methods: {
			archive(resp) {

				let responseData = this.responses.map(f => {
					if(f.id == resp.id) {
						f.is_active = false
					}

					return f
				})

				window.axios.post(`/response/${resp.id}`)
				.then(response => {

				})
			},
			deleteResponse(resp) {
				let responseData = this.responses.filter(f => {
					return f.id !== resp.id
				})

				console.log('responseData', responseData)

				this.responses = responseData

				window.axios.delete(`/response/${resp.id}`)
				.then(response => {

				})
			},
			getDate(resp) {
				return new Date(Date.parse(resp.created_at)).toLocaleString()
			},
			getFrom(resp) {
				if(resp.data) {

					let tempData = resp.data

					if(tempData.email) {
						return tempData.email
					}

					if(tempData.email_address) {
						return tempData.email_address
					}

					if(tempData.name) {
						return tempData.name
					}

					if(tempData.first_name && tempData.last_name) {
						return `${tempData.first_name} ${tempData.last_name}`
					}
				}

				return resp.ip_address
			},
			getData(resp) {

				let dataResponse = '',
					fields = resp.data

				const keys = Object.keys(fields)

				for (const key of keys) {
					dataResponse += `<strong>${key}: </strong>${fields[key]}<br />`
				}

				return dataResponse

			},
			getStatus(resp) {

				if(resp.is_spam) {
					return 'spam'
				}

				return resp.is_active ? 'active' : 'archived'

			},
			getStatusClass(resp) {

				if(resp.is_spam) {
					return 'bg-gray-800'
				}

				return resp.is_active ? 'bg-green-500' : 'bg-yellow-500'

			},
		},
		computed: {

		}
	};
</script>