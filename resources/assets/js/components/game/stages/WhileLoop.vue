<template>
	<div>
		<el-steps :space="500" :active="active" finish-status="success" :align-center="true" :center="true">
			<el-step title="Intro"></el-step>
			<el-step title="Question"></el-step>
		</el-steps>
	
	
		<keep-alive>
			<component :is="mode" :questions="questions"></component>
		</keep-alive>
		<!--<while-loop-intro v-show="active === 0"></while-loop-intro>-->
		<!--<while-loop-question v-show="active === 1"></while-loop-question>-->
	
	</div>
</template>

<script>
	import WhileLoopIntro from './WhileLoopIntro.vue';
	import WhileLoopQuestion from './WhileLoopQuestion.vue';
	
	export default {
		props: ['questions', 'answers'],
		components: {
			WhileLoopIntro,
			WhileLoopQuestion,
		},
		data() {
			return {
				active: 0,
				mode: 'while-loop-intro',
			};
		},
		methods: {
			sendQuestions() {
				this.$events.fire('sendQuestions', this.questions);
			}
		},
		events: {
			nextStep() {
				//console.log(this.questions);
				this.active++;
				this.mode = 'while-loop-question';
				this.sendQuestions();
	
				//this.$events.fire('sendQuestions', this.questions);
				//console.log(this.active);
				//window.location.href = 'question';
			},
			completed(errorRatio) {
				const self = this;
	
				axios.post(COMPLETED_STAGE_POST_URL, {
					stage_id: self.questions[0].stage_id,
					error_ratio: errorRatio,
				}).then(response => {
					self.$swal('Congratulations! <i class="eo-32 eo-tada"></i>', `You've got <br><i class="eo-32 eo-money_mouth_face"></i>${response.data.coin}<span class="badge">Coin</span><br><span class="eo-20 eo-heart_eyes"></span>${response.data.coin}<span class="badge">EXP</span>`)
						.then(() => {
							window.location.href = TUTORIAL_URL;
						});
				});
			}
		},
		mounted() {
			//console.log(this.questions[0]);
			//			console.log(this.answers);
	
		},
		created() {
	
		}
	}
</script>

<style scoped>
	
</style>