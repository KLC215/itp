<template>
    <div :class="disabledBlock">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div v-if="hasQuestion">
                    <codemirror v-model="question.data[index].question.problem" :options="editorOptions"
                                class="CodeMirror">
                    </codemirror>
                    <hr>
                    <h1 class="panel-title text-center" v-html="question.data[index].question.ask_for"></h1>
                </div>
            </div>
            <div class="panel-body">
                <div style="margin: 1em 2em;">
                    <el-alert
                            title="Hint"
                            type="info"
                            v-html="hints.data"
                            show-icon
                            :closable="false"
                            v-show="hints.show"
                            style="margin-bottom: 0.5em;">
                    </el-alert>
                    <div v-if="question.data[index].question_type.name === 'input'">
                        <div class="text-center">
                            <div class="row">
                                <el-input placeholder="Number only" v-model="inputAns.data">
                                    <template slot="prepend">{{ inputAns.prepend }}</template>
                                </el-input>
                            </div>

                        </div>
                    </div>
                    <div v-else-if="question.data[index].question_type.name === 'table'">
                        <div class="text-center">
                            <div class="row">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th v-for="prop in tableAns.props" class="text-center">{{ prop }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(data, index) in tableAns.data">
                                        <td v-for="(value, key) in data">
                                            <el-input v-model="tableAns.answers[index][key]"></el-input>
                                            <!--<input type="text" style="border: none;" v-model="tableAns.answers[index][key]">-->
                                            {{ index }}. {{ key }} : {{ value }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="question.data[index].question_type.name === 'mc'">
                        <div class="col-xs-12 col-sm-6 text-center"
                             v-for="answer in mc.btnAnswers">
                            <button class="btn btn-primary btn-lg"
                                    :disabled="answer.disabled"
                                    style="margin: 10px"
                                    @click="checkMCAnswers(answer)">
                                {{ answer.data }}
                            </button>
                        </div>
                    </div>
                    <div v-else-if="question.data[index].question_type.name === 'coding'">

                        <codemirror v-model="codingAns.answer" :options="editorOptions2"
                                    class="CodeMirror"></codemirror>


                    </div>
                    <hr>
                    <div class="row pull-right">
                        <el-button
                                type="success"
                                icon="check"
                                @click="submitAnswer(question.data[index].question_type.name)"
                                v-show="question.data[index].question_type.name !== 'mc'">
                            Submit&nbsp;<i class="eo-16 eo-smile"></i>
                        </el-button>
                        <el-tooltip class="item" effect="dark" content="It costs 200 coins!" placement="right">
                            <el-button
                                    type="info"
                                    icon="information"
                                    @click="getHints(question.data[index])"
                                    :disabled="hints.bought">
                                Need help&nbsp;<i class="eo-16 eo-cry"></i>
                            </el-button>
                        </el-tooltip>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import { SUCCESS_SOUND, ERROR_SOUND } from '../../../core/sounds';
    import {
        CHALLENGES_URL,
        COMPLETE_CHALLENGE_POST_URL,
    } from '../../../core/urls';

    export default {
        props: ['question-data', 'answer-data', 'challenge-data', 'badge-data'],

        data() {
            return {
                index: 0,
                show: false,
                question: {
                    data: this.questionData,
                },
                answer: {
                    data: this.answerData,
                },
                badges: this.badgeData,
                challenge: this.challengeData,
                statistics: {
                    correctRatio: 0,
                    errorRatio: 0,
                    startTime: '',
                    endTime: '',
                },
                mc: {
                    correctAnswer: 0,
                    btnAnswers: [],
                    fakeNumbers: [],
                },
                inputAns: {
                    prepend: '',
                    answer: '',
                    data: '',
                },
                tableAns: {
                    data: [],
                    props: [],
                    answers: [],
                },
                codingAns: {
                    data: '',
                    answer: '',
                },
                hints: {
                    data: '',
                    show: false,
                    bought: false,
                    ratio: 0,
                },
                editorOptions: {
                    tabSize: 4,
                    styleActiveLine: true,
                    line: true,
                    mode: 'text/x-java',
                    lineWrapping: true,
                    readOnly: true,
                    collapsed: false,
                },
                editorOptions2: {
                    tabSize: 4,
                    styleActiveLine: true,
                    line: true,
                    mode: 'text/x-java',
                    lineWrapping: true,
                    readOnly: false,
                },
            };
        },

        methods: {
            initQuestions() {
                let data = this.question.data[this.index];
                if (data.question.problem.includes('/ans/')) {
                    this.mc.correctAnswer = _.random(3, 20);
                    data.question.problem = data.question.problem.replace(/\/ans\//g, this.mc.correctAnswer + 1);
                }
                this.initAnswers(data);
            },
            initAnswers(data) {
                //console.log('initAnswers: ', data);
                switch (data.question_type.name) {
                    case 'input':
                        this.initInputAnswers();
                        break;
                    case 'table':
                        this.initTableAnswers();
                        break;
                    case 'mc':
                        this.initMCAnswers();
                        break;
                    case 'coding':
                        this.initCodingAnswer();
                        break;
                }

            },
            initInputAnswers() {
                let ans = this.answer.data[this.index].answer.split(':');
                _.forEach(ans, (data, index) => {
                    ans[index] = data.trim();
                });
                this.inputAns.prepend = ans[0];
                this.inputAns.answer = ans[1];
            },
            initTableAnswers() {
                let ans = this.answer.data[this.index].answer.split("\r").map((item) => {
                    return item.split(",");
                });
                let props = [];
                let tableAnswers = [];
                let splitedAnswers = [];

                _.forEach(ans, (item) => {
                    props.push(item[0]);
                    let answers = [];
                    for (let i = 1; i < item.length; i++) {
                        answers.push(item[i]);
                    }
                    splitedAnswers.push(answers);
                    answers = [];
                });
                this.tableAns.props = props;

                for (let j = 0; j < splitedAnswers[0].length; j++) {
                    let i = 0;
                    let temp = [];
                    while (i < splitedAnswers.length) {
                        temp.push(splitedAnswers[i][j]);
                        i++;
                    }
                    tableAnswers.push(_.zipObject(props, temp));
                    i = 0;
                    temp = [];
                }
                this.tableAns.data = tableAnswers;
                this.tableAns.data = JSON.parse(JSON.stringify(this.tableAns.data).replace(/\r?\n|\r/g));
                let answers = [];

                for (let i = 0; i < tableAnswers.length; i++) {
                    answers[i] = {};
                    for (let prop in tableAnswers[i]) {
                        answers[i][prop] = tableAnswers[i][prop];
                    }
                }

                _.forEach(answers, (answer) => {
                    _.forEach(props, (prop) => {
                        answer[prop] = '';
                    });
                });
                this.tableAns.answers = answers;
                console.log(this.tableAns.data);
                console.log('prepare: ', answers);
            },
            initMCAnswers() {
                let data = this.answer.data[this.index];
                if (this.mc.correctAnswer === 0) {
                    this.mc.correctAnswer = data.answer;
                    console.log('Correct ans: ', this.mc.correctAnswer);
                }

                this.mc.btnAnswers.push({
                    correct: true,
                    data: this.mc.correctAnswer,
                    disabled: false
                });

                for (let i = 0; i < 3; i++) {
                    this.mc.btnAnswers.push({
                        correct: false,
                        data: this.randomNumber(this.mc.correctAnswer),
                        disabled: false
                    });
                }
                this.mc.btnAnswers = _.shuffle(this.mc.btnAnswers);
            },
            initCodingAnswer() {
                console.log(this.answer.data[this.index].answer);
                this.codingAns.data = this.answer.data[this.index].answer.replace(/\r/g, '');
            },
            randomNumber(max) {
                let number = _.random(3, max);
                if (number === this.mc.correctAnswer || _.includes(this.mc.fakeNumbers, number)) {
                    return this.randomNumber();
                }
                this.mc.fakeNumbers.push(number);

                return number;
            },
            submitAnswer(questionType) {
                switch (questionType) {
                    case 'input':
                        this.checkInputAnswers();
                        break;
                    case 'table':
                        this.checkTableAnswers();
                        break;
                    case 'mc':
                        this.checkMCAnswers();
                        break;
                    case 'coding':
                        this.checkCodingAnswer();
                        break;
                }
            },
            checkInputAnswers() {
                const self = this;
                console.log(this.question.data.length);
                if (this.inputAns.data !== this.inputAns.answer) {
                    this.statistics.errorRatio += 1;
                    this.$swal("Oops...", 'Wrong answer, try again <i class="eo-32 eo-relaxed"></i>', "error")
                        .then(() => {
                            self.$events.fire('updateWrong');
                        });
                    ERROR_SOUND.play();
                    return;
                }
                this.$events.fire('updateCorrect');
                this.statistics.correctRatio += 1;
                this.inputAns.prepend = '';
                this.inputAns.data = '';
                this.inputAns.answer = '';
                this.clearHints();
                this.$swal("Good job!", '<i class="eo-32 eo-confetti_ball"></i>&nbsp; Correct! &nbsp;<i class="eo-32 eo-confetti_ball"></i>', "success")
                    .then(() => {
                        self.checkFinish();
                    });
                SUCCESS_SOUND.play();
            },
            checkTableAnswers() {
                const self = this;
                if (!_.isEqual(this.tableAns.data, this.tableAns.answers)) {
                    this.statistics.errorRatio += 1;
                    this.$swal("Oops...", 'Wrong answer, try again <i class="eo-32 eo-relaxed"></i>', "error")
                        .then(() => {
                            self.$events.fire('updateWrong');
                        });
                    ERROR_SOUND.play();
                    return;
                }
                this.$events.fire('updateCorrect');
                this.statistics.correctRatio += 1;
                this.tableAns.data = [];
                this.tableAns.props = [];
                this.tableAns.answers = [];
                this.clearHints();
                this.$swal("Good job!", '<i class="eo-32 eo-confetti_ball"></i>&nbsp; Correct! &nbsp;<i class="eo-32 eo-confetti_ball"></i>', "success")
                    .then(() => {
                        self.checkFinish();
                    });
                SUCCESS_SOUND.play();
            },
            checkMCAnswers(answer) {
                const self = this;
                if (!answer.correct) {
                    this.statistics.errorRatio += 1;
                    answer.disabled = true;
                    this.$swal('Oops...', 'Wrong answer, try again <i class="eo-32 eo-relaxed"></i>', 'error')
                        .then(() => {
                            self.$events.fire('updateWrong');
                        });
                    ERROR_SOUND.play();
                    return;
                }
                this.$events.fire('updateCorrect');
                this.statistics.correctRatio += 1;
                this.mc.correctAnswer = 0;
                this.mc.btnAnswers = [];
                this.mc.fakeNumbers = [];
                this.clearHints();
                this.$swal('Good job!', '<i class="eo-32 eo-confetti_ball"></i>&nbsp; Correct! &nbsp;<i class="eo-32 eo-confetti_ball"></i>', 'success')
                    .then(() => {
                        //self.completed(finishTime);
                        self.checkFinish();
                    });
                SUCCESS_SOUND.play();
            },
            checkCodingAnswer() {
                const self = this;
                if (!_.isEqual(this.codingAns.data, this.codingAns.answer)) {
                    this.statistics.errorRatio += 1;
                    this.$swal('Oops...', 'Wrong answer, try again <i class="eo-32 eo-relaxed"></i>', 'error')
                        .then(() => {
                            self.$events.fire('updateWrong');
                        });
                    ERROR_SOUND.play();
                    return;
                }
                this.$events.fire('updateCorrect');
                this.statistics.correctRatio += 1;
                this.codingAns.data = [];
                this.codingAns.answers = [];
                this.clearHints();
                this.$swal('Good job!', '<i class="eo-32 eo-confetti_ball"></i>&nbsp; Correct! &nbsp;<i class="eo-32 eo-confetti_ball"></i>', 'success')
                    .then(() => {
                        //self.completed(finishTime);
                        self.checkFinish();
                    });
                SUCCESS_SOUND.play();
            },
            checkFinish() {
                const self = this;
                console.log('Index', this.index);
                console.log('Question length', this.question.data.length);
                if (this.index >= this.question.data.length - 1) {
                    this.statistics.endTime = moment.utc(moment(), 'HH:mm:ss');
                    let finishTime = moment.duration(this.statistics.endTime.diff(this.statistics.startTime)).asMilliseconds();
                    this.completed(finishTime);
                    //this.$swal("Good job!", "You finished!", "success");
                } else {
                    this.index += 1;
                    this.initQuestions();
                }
            },
            clearHints() {
                this.hints.data = '';
                this.hints.show = false;
                this.hints.bought = false;
            },
            getHints(question) {
                const self = this;
                this.$swal({
                    title: 'Are you sure to get a tip?',
                    text: "You will be deducted 200 coins!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK!'
                }).then(function () {
                    axios.post(HINTS_POST_URL)
                         .then((response) => {
                             if (response.data.success) {
                                 self.hints.show = true;
                                 self.hints.data = '<b>Hint: </b>' + question.hints;
                                 self.hints.bought = true;
                                 self.hints.ratio += 1;
                             } else {
                                 self.$swal('Oops...', response.data.message, 'error');
                             }
                         });
                });
            },
            startTimer() {
                this.statistics.startTime = moment.utc(moment(), 'HH:mm:ss');
            },
            completed(finishTime) {
                const self = this;
                console.log('complete');
                let badgeId = 0;
                let image = null;
                if (this.badges[0]) {
                    badgeId = this.badges[0].id;
                    image = this.badges[0].image;
                }
                this.$swal("Good job!", "You did a great job!", "success")
                    .then(() => {
                        console.log('ajax');
                        axios.post(COMPLETE_CHALLENGE_POST_URL, {
                            stageId: self.challenge.id,
                            finishTime: finishTime,
                            correctRatio: self.statistics.correctRatio,
                            errorRatio: self.statistics.errorRatio,
                            badgeId: badgeId
                        }).then(response => {
                            if (response.data.exp && response.data.coin) {
                                self.$swal('Congratulations! <i class="eo-32 eo-tada"></i>', `You've got <br><img src="/images/coin_32.png" alt="Coin">&nbsp;&nbsp;${response.data.coin}<br><img src="/images/ic_exp_32.png" alt="EXP">&nbsp;&nbsp;${response.data.coin}`)
                                    .then(() => {
                                        self.$swal('<img src="' + image + '" alt="badge" width="200" height="200">', 'You got a new badge!', 'info')
                                            .then(() => {
                                                window.location.href = CHALLENGES_URL;
                                            }, function (dismiss) {
                                                if (dismiss === 'overlay') {
                                                    window.location.href = CHALLENGES_URL;
                                                }
                                            });
                                    });
                            }
                        });
                    });

            },
            leaving() {
                this.$swal('xxx', 'You are leaving!', 'warning');
            }
        },
        computed: {
            hasQuestion() {
                return this.index <= this.question.data.length;
            },
            disabledBlock() {
                return this.show ? '' : 'disabledBlock';
            }
        },
        events: {
            showQuestionBlock() {
                this.show = true;
                this.startTimer();
            },
            timeIsUp() {
                this.$swal('Oops...', 'Time is up!!', 'info');
                this.show = false;
                this.statistics.endTime = moment.utc(moment(), 'HH:mm:ss');
                let finishTime = moment.duration(this.statistics.endTime.diff(this.statistics.startTime)).asMilliseconds();
                this.completed(finishTime);
            },
            noHealths() {
                const self = this;
                this.statistics.endTime = moment.utc(moment(), 'HH:mm:ss');
                let finishTime = moment.duration(this.statistics.endTime.diff(this.statistics.startTime)).asMilliseconds();
                this.show = false;
                this.$swal('Oops...', 'You have no health!!', 'info')
                    .then(() => {
                        self.completed(finishTime);
                    });
            }
        },
        created() {
            console.log(this.question);
            console.log(this.answer);
            console.log(this.challenge);
            //            console.log(this.question.data[this.question.index].question_type.name);
            this.initQuestions();
        },
    }
</script>

<style scoped>
    .disabledBlock {
        pointer-events: none;
        opacity: 0.05;
    }
</style>