<template>
	<div class="panel panel-default">
		<div class="panel-heading">
			<!--<pre v-highlightjs>-->
			<!--<code class="java">-->
			<!--{{ questionsData[0].question.problem }}-->
			<!--</code>-->
			<!--</pre>-->

			<codemirror v-model="questionsData[0].question.problem"
						:options="editorOptions"
						class="CodeMirror"></codemirror>
			<hr>
			<h2 class="panel-title text-center">{{ questionsData[0].question.ask_for }}</h2>
		</div>
		<div class="panel-body">
			<div class="col-xs-12 col-sm-6 text-center">
				<button class="btn btn-primary btn-lg"
						:disabled="btnData[0].disabled"
						style="margin: 10px"
						@click="onAnswer(btnData[0])">{{ btnData[0].data }}

				</button>
			</div>
			<div class="col-xs-12 col-sm-6 text-center">
				<button class="btn btn-primary btn-lg"
						:disabled="btnData[1].disabled"
						style="margin: 10px"
						@click="onAnswer(btnData[1])">{{ btnData[1].data }}

				</button>
			</div>
			<div class="col-xs-12 col-sm-6 text-center">
				<button class="btn btn-primary btn-lg"
						:disabled="btnData[2].disabled"
						style="margin: 10px"
						@click="onAnswer(btnData[2])">{{ btnData[2].data }}

				</button>
			</div>
			<div class="col-xs-12 col-sm-6 text-center">
				<button class="btn btn-primary btn-lg"
						:disabled="btnData[3].disabled"
						style="margin: 10px"
						@click="onAnswer(btnData[3])">{{ btnData[3].data }}

				</button>
			</div>
		</div>
	</div>
</template>

<script>
	import { SUCCESS_SOUND, ERROR_SOUND } from '../../../core/sounds';

	export default{
		props: ['questions'],
		data() {
			return {
				questionsData: null,
				errorRatio: 0,
				btnData: [],
				editorOptions: {
					tabSize: 4,
					styleActiveLine: true,
					line: true,
					mode: 'text/x-java',
					lineWrapping: true,
					readOnly: true,
				},
			};
		},
		methods: {
			onAnswer(answer) {

				const self = this;

				if (!answer.correct) {
					this.errorRatio++;
					answer.disabled = true;

					this.$swal('Oops...', 'Wrong answer, try again <i class="eo-32 eo-relaxed"></i>', 'error')
						.then(() => {
							if (this.errorRatio >= 2) {
								this.$swal({
									title: 'Umm...',
									html: "It seems like you don't understand <b>While Loop</b><br>Let's go back to intro again<i class='eo-32 eo-relaxed'></i>",
									type: 'warning',
									showCancelButton: false,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'Fighting! <i class="eo-32 eo-blush">'
								}).then(function () {
									for (let i = 0; i < self.btnData.length; i++) {
										self.btnData[i].disabled = false;
									}
									location.reload();
								});
							}
						});
					ERROR_SOUND.play();



					return;
				}


				this.$swal('Good job!', 'You know what <b>While Loop</b> is! <i class="eo-32 eo-sunglasses"></i>', 'success')
					.then(() => {
						self.$events.fire('completed', self.errorRatio);
					});
				SUCCESS_SOUND.play();
				//this.$emit('answered', isCorrect);

			},
			shuffle(a) {
				for (let i = a.length; i; i--) {
					let j = Math.floor(Math.random() * i);
					[a[i - 1], a[j]] = [a[j], a[i - 1]];
				}
			},
			generateQuestion() {
				let correct = '';

				this.questionsData[0].answers.forEach((answer) => {
					if (answer.is_correct) {
						correct = answer.answer;
					}

					this.btnData.push({ correct: answer.is_correct, data: answer.answer, disabled: false });

					this.shuffle(this.btnData);
				});

				this.questionsData[0].question.problem = this.questionsData[0].question.problem.replace(/\/\/ans/g, correct);
			}
		},
		created() {
			this.questionsData = this.questions;
			this.errorRatio = this.questions[0].question.error_ratio;
			this.generateQuestion();
		},
		activated() {
			console.log(this.questionsData[0]);
		}
	}
</script>

<style scoped>

</style>