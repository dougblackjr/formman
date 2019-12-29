<template>
	<div>
		<div class="flex flex-wrap -mx-4 mb-8">
		    <div class="w-full md:w-1/3 px-4 mb-6 lg:mb-0">
		        <div class="h-full">
		            <div class="text-center p-4 mb-2 bg-blue-500 text-white rounded">
		                <h3 class="text-3xl leading-tight font-heading font-semibold">{{ form.responses_count }}</h3><span class="leading-none">Total Responses</span></div>
		        </div>
		    </div>
		    <div class="w-full md:w-1/3 px-4 mb-6 lg:mb-0">
		        <div class="h-full">
		            <div class="text-center p-4 mb-2 bg-red-500 text-white rounded">
		                <h3 class="text-3xl leading-tight font-heading font-semibold">{{ form.recent_count }}</h3><span class="leading-none">Last 24 Hours </span></div>
		        </div>
		    </div>
		    <div class="w-full md:w-1/3 px-4 mb-6 lg:mb-0">
		        <div class="h-full">
		            <div class="text-center p-4 mb-2 bg-green-500 text-white rounded">
		                <h3 class="text-3xl leading-tight font-heading font-semibold">{{ form.spam_count }}</h3><span class="leading-none">Total Spam</span></div>
		        </div>
		    </div>
		</div>
		<table class="w-full table-auto">
		    <thead>
		        <tr>
		            <th class="border-t px-2 py-2" scope="col">ID #</th>
		            <th class="border-t px-2 py-2" scope="col">Name</th>
		            <th class="border-t px-2 py-2" scope="col">Slug</th>
		            <th class="text-center border-t px-2 py-2" scope="col">Status</th>
		            <th class="text-center border-t px-2 py-2" scope="col">Responses</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr v-for="f in form.responses" :key="f.id">
		            <td class="border-t px-2 py-2">{{ f.id }}</td>
		            <td class="border-t px-2 py-2">{{ f.name }}</td>
		            <td class="border-t px-2 py-2">{{ f.slug }}</td>
		            <td class="text-center border-t px-2 py-2">
		            	<span class="inline-block text-sm py-1 px-3 rounded-full text-white bg-yellow-500" :class="f.enabled ? 'bg-green-500' : 'bg-gray-800'">{{ f.enabled ? 'Enabled' : 'Disabled' }}</span>
		            </td>
		            <td class="text-center border-t px-2 py-2">{{ f.responses_count }}</td>
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

			}
		},
		methods: {
			
		},
		computed: {

		}
	};
</script>