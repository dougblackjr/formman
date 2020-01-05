<template>
	<modal>
		<template slot="modal-title">
			How Your Form Works
		</template>
		<template slot="modal-content">
			<p class="text-lg">Adding your form is easy! You can basically add anything to your form, we'll just get you started!</p>
			<p class="text-md"><strong>1: </strong>Copy your action URL by hitting this button -><copy-button :copy="form.url" /></p>
			<p class="text-md"><strong>2: </strong>Add your action URL to your form action.</p>
			<p class="text-md"><strong>3: </strong>Add the spam field (see the below example).</p>
			<p class="text-md"><strong>4: </strong>Add your other field inputs.</p>
			<p class="text-md"><strong>5: </strong>You're ready! Send it to the world! Your responses will appear on this page.</p>
			<p class="text-xs"><strong>Action URL:</strong> {{ form.url }} <copy-button :copy="form.url" /></p>
			<p class="text-2x mt-3"><strong>Example Form (with name and email)</strong></p>
			<pre lang="html" class="text-sm">{{ htmlCodeVariable }}</pre>
		</template>
	</modal>
</template>

<script>

	export default {
		props: {
			form: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
				htmlCodeVariable: `
<form action="${this.form.url}"
		method="POST"
		accept-charset="utf-8">
	<label for="name">Name</label>
	<input type="text" name="name" />
	<label for="name">Email</label>
	<input type="text" name="email" />
	<!-- Here's the spam field -->
	<input type="checkbox" name="important_checkbox" value="yes" style="display:none !important" tabindex="-1" autocomplete="off" />
	<input type="hidden" name="redirect" value="https://example.com" />
	<input type="submit" value="Submit" />
</form>`
			}
		}
	};
</script>