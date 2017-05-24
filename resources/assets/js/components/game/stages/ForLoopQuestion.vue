<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <codemirror v-model="questions.question.problem"
                        :options="editorOptions"
                        class="CodeMirror">
            </codemirror>
            <hr>
            <h1 class="panel-title text-center" v-html="questions.question.ask_for"></h1>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-6 text-center"
                 v-for="answer in btnAnswers">
                <button class="btn btn-primary btn-lg"
                        :disabled="answer.disabled"
                        style="margin: 10px"
                        @click="onAnswer(answer)">
                    {{ answer.data }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { SUCCESS_SOUND, ERROR_SOUND } from '../../../core/sounds';
    import { TUTORIAL_URL, COMPLETE_STAGE_POST_URL } from '../../../core/urls';

    export default{
        props: ['question-data', 'answer-data', 'badge-data'],

        data() {
            return {
                questions: this.questionData[0],
                answers: this.answerData,
                badges: this.badgeData,
                correctAnswer: 0,
                errorRatio: this.questionData[0].question.error_ratio,
                btnAnswers: [],
                fakeNumbers: [],
                startTime: '',
                endTime: '',
                timerInterval: null,
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
                    console.log('Error ratio', this.errorRatio);
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
                                    window.location.href = '/arcades/tutorial/for-loop/intro';
                                }, function (dismiss) {
                                    if (dismiss === 'overlay') {
                                        window.location.href = '/arcades/tutorial/for-loop/intro';
                                    }
                                });
                            }
                        });
                    ERROR_SOUND.play();
                    return;
                }
                this.endTime = moment.utc(moment(), 'HH:mm:ss');
                let finishTime = moment.duration(this.endTime.diff(this.startTime)).asMilliseconds();

                console.log(finishTime);
                this.$swal('Good job!', 'You know what <b>Do While Loop</b> is! <i class="eo-32 eo-sunglasses"></i>', 'success')
                    .then(() => {
                        self.completed(finishTime);
                    });
                SUCCESS_SOUND.play();
            },
            shuffle(a) {
                for (let i = a.length; i; i--) {
                    let j = Math.floor(Math.random() * i);
                    [a[i - 1], a[j]] = [a[j], a[i - 1]];
                }
            },
            initQuestions() {
                this.correctAnswer = _.random(3, 10);

                console.log('Correct ans', this.correctAnswer);

                this.btnAnswers.push({
                    correct: true,
                    data: this.correctAnswer,
                    disabled: false
                });
                this.questions.question.problem = this.questions.question.problem.replace(/\/ans\//g, this.correctAnswer + 1);

                for (let i = 0; i < 3; i++) {
                    this.btnAnswers.push({
                        correct: false,
                        data: this.initAnswers(),
                        disabled: false
                    });
                }

                this.shuffle(this.btnAnswers);
            },
            initAnswers() {
                let number = _.random(3, 15);
                if (number === this.correctAnswer || _.includes(this.fakeNumbers, number)) {
                    return this.initAnswers();
                }
                this.fakeNumbers.push(number);
                return number;
            },
            startTimer() {
                this.startTime = moment.utc(moment(), 'HH:mm:ss');
            },
            completed(finishTime) {
                const self = this;

                let image = null;
                let badgeId = 0;
                if (this.badges[0]) {
                    badgeId = this.badges[0].id;
                    image = this.badges[0].image;
                }
                axios.post(COMPLETE_STAGE_POST_URL, {
                    stageId: self.questions.stage_id,
                    levelId: self.questions.level_id,
                    finishTime: finishTime,
                    errorRatio: self.errorRatio,
                    badgeId: badgeId,
                }).then(response => {
                    if (response.data.exp && response.data.coin) {
                        self.$swal('Congratulations! <i class="eo-32 eo-tada"></i>', `You've got <br><img src="/images/coin_32.png" alt="Coin">&nbsp;&nbsp;${response.data.coin}<br><img src="/images/ic_exp_32.png" alt="EXP">&nbsp;&nbsp;${response.data.coin}`)
                            .then(() => {
                                self.$swal('<img src="' + image + '" alt="badge" width="100" height="100">', 'You got a new badge!', 'info')
                                    .then(() => {
                                        window.location.href = TUTORIAL_URL;
                                    }, function (dismiss) {
                                        if (dismiss === 'overlay') {
                                            window.location.href = TUTORIAL_URL;
                                        }
                                    });
                            });
                    }
                    if (response.data.message) {
                        self.$swal('Congratulations! <i class="eo-32 eo-tada"></i>', response.data.message)
                            .then(() => {
                                window.location.href = TUTORIAL_URL;
                            }, function (dismiss) {
                                if (dismiss === 'overlay') {
                                    window.location.href = TUTORIAL_URL;
                                }
                            });
                    }
                });
            }
        },

        created() {
            this.initQuestions();
            this.startTimer();
            console.log(this.badges);
        },
    }
</script>

<style scoped>

</style>