<template>
	<el-input-number v-model="qty" @change="handleChange" :min="1" :max="10"></el-input-number>
</template>

<script>
	export default {
		data() {
			return {
				qty: 1,
			};
		},

		methods: {
			handleChange(qty) {
				this.$events.fire('changedQty', qty);
			}
		},
	}
</script>