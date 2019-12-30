<template>
	<div class="modal">
		<div v-if="$store.state.showModal" class="modal modal-overlay absolute w-full h-full bg-gray-900 opacity-50" style="top:0;left:0;right:0;bottom:0;"></div>
		<vue-tailwind-modal :showing="$store.state.showModal" @close="toggleModalInternal">
			<div class="bg-white w-full mx-auto rounded z-50 overflow-y-auto">
				<!-- Add margin if you want to see some of the overlay behind the modal-->
				<div class="py-4 text-left px-6">
					<!--Title-->
					<div class="flex justify-between items-center pb-3">
						<p class="text-2xl font-bold"><slot name="modal-title"></slot></p>
					</div>
					<!--Body-->
					<slot name="modal-content"></slot>
					<!--Footer-->
					<div class="flex justify-end pt-2">
						<button v-on:click="toggleModalInternal" class="modal-close px-4 bg-blue-500 p-3 rounded-lg text-white hover:bg-blue-400">Sweet, thanks!</button>
					</div>
				</div>
			</div>
		</vue-tailwind-modal>
	</div>
</template>

<script>

	import VueTailwindModal from 'vue-tailwind-modal'
	export default {
		components: {
			VueTailwindModal
		},
		data() {
			return {

			}
		},
		methods: {
			toggleModalInternal() {
				this.$store.dispatch('toggleModal')
			},
			closeModal() {
				this.$store.commit('setShowModal', false)
			}
		}
	};
</script>