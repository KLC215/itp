<template>
	<el-steps :space="500" :active="active" finish-status="success" :align-center="true" :center="true">
		<el-step title="Intro"></el-step>
		<el-step title="Question"></el-step>
	</el-steps>
</template>

<script>
	export default {
		data() {
			return {
				active: 0,
			};
		},
	}
</script>

<style scoped>

</style>