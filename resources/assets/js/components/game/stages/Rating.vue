<template>
	<el-rate v-model="rate" disabled></el-rate>
</template>

<script>
	export default {
		props: ['stage'],
		data() {
			return {
				stageData: this.stage,
				rate: 0,
			};
		},
	}
</script>

<style scoped>

</style>