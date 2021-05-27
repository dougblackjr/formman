<template>
	<div>
		<div id="bar">
			<h1>Make sure to save your design!</h1>
			<button v-on:click.prevent="save" class="inline-block w-full py-4 px-8 leading-none text-white bg-blue-500 hover:bg-blue-600 rounded shadow">Save Design</button>
		</div>
		<EmailEditor
			ref="emailEditor"
			v-on:load="editorLoaded"
			v-on:change=""
		/>
		<textarea :name="inputName" ref="emailEditorTextarea" style="display:none"></textarea>
	</div>
</template>

<script>
	import { EmailEditor } from 'vue-email-editor'
	export default {
		components: {
			EmailEditor
		},
		props: {
			inputName: {
				type: String,
				required: true
			},
			val: {
			}
		},
		data() {
			return {
				templateData: ''
			}
		},
		methods: {
			editorLoaded() {
				// Pass the template JSON here
				if(this.val) {
					this.$refs.emailEditor.editor.loadDesign(JSON.parse(this.val));
					this.save()
				}
			},
			save() {
				let designToOutput = {}
				this.$refs.emailEditor.editor.saveDesign(
					(design) => {
						designToOutput.design = design
					}
				)
				this.$refs.emailEditor.editor.exportHtml(
					(data) => {
						designToOutput.html = data.html
					}
				)

				setTimeout(() => {
					this.templateData = JSON.stringify(designToOutput)
					console.log('this.templateData', this.templateData)
					this.$refs.emailEditorTextarea.value = this.templateData
				}, 1500)

			}
		},
		computed: {

		},
		mounted() {
		}
	};
</script>
<style lang="scss">
#editor-1 iframe {
	min-height: 500px !important;
}
</style>