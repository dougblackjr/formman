<template>
	<div>
		<inline-credit-card-field v-model="card" v-on:change="updateCard"></inline-credit-card-field>
	</div>
</template>

<script>

	// import { CreditCardField, InlineCreditCardField } from 'vue-credit-card-field';
	import CreditCardField from 'vue-credit-card-field/src/Components/CreditCardField';
	import InlineCreditCardField from 'vue-credit-card-field/src/Components/InlineCreditCardField';

	export default {
		components: {
		    CreditCardField,
		    InlineCreditCardField
		},
		data() {
			return {
				card: {}
			}
		},
		methods: {
			updateCard() {
				let cardNumber = document.getElementById('card_number')
				cardNumber.value = this.card.number
				let cardExp = document.getElementById('card_exp')
				cardExp.value = this.card.expiration
				let cardCvc = document.getElementById('card_cvc')
				cardCvc.value = this.card.cvc
				let cardZip = document.getElementById('card_zip')
				cardZip.value = this.card.postalCode
			}
		}
	};
</script>
<style lang="scss" scoped>
</style>