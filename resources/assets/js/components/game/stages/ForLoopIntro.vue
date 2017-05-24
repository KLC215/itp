<template>
    <div>
        <div id="explain" class="well">
            <h4>For loop executes group of Java statements as long as the boolean condition evaluates to true.</h4>
        </div>
        <div id="syntax">
            <button class="btn btn-info" @click="startWithSyntaxIntro">See syntax intro</button>
            <codemirror v-model="code[0]" :options="editorOptions"></codemirror>

        </div>
        <hr>
        <div id="example">
            <button class="btn btn-info" @click="startWithExampleIntro">See example intro</button>
            <codemirror v-model="code[1]" :options="editorOptions"></codemirror>
        </div>
        <hr>
        <div class="text-right">
            <button @click="nextStep" id="next-step" class="btn btn-success">
                Next step
            </button>
        </div>
    </div>
</template>

<script>
    import { introJs } from 'intro.js';

    export default {
        props: ['data'],

        data() {
            return {
                intro: introJs(),
                active: 0,
                code: [
                    "for ( <initialization> ; <condition> ; <statement> ) { \n\t<Block of statements>; \n}",
                    "for (int i = 0 ; i < 3 ; i++) { \n\tSystem.out.println(i); \n}"
                ],
                editorOptions: {
                    tabSize: 4,
                    styleActiveLine: true,
                    line: true,
                    mode: 'text/x-java',
                    lineWrapping: true,
                    readOnly: true,
                },
                introConfig: {
                    steps: [
                        {
                            intro: "<h3>Let's learn about For loop <i class='eo-32 eo-smile'></i></h3>"
                        },
                        {
                            element: '#explain',
                            intro: "<h3>Here is the easiest way to understand the flow of for loop</h3>"
                        },
                        {
                            intro: "<h3>Easy enough? <i class='eo-32 eo-joy'></i></h3>"
                        },
                        {
                            element: '#syntax',
                            intro: "<h3>Here is the syntax of a for loop</h3>"
                        },
                        {
                            element: '#syntax',
                            intro: "<h3>The initialization statement is executed before the loop starts. It is generally used to initialize the loop variable.</h3>"
                        },
                        {
                            element: '#syntax',
                            intro: "<h3>Condition statement is evaluated before each time the block of statements are executed. Block of statements are executed only if the boolean condition evaluates to true.</h3>"
                        },
                        {
                            element: '#syntax',
                            intro: "<h3>Statement is executed after the loop body is done. Generally it is being used to increment or decrement the loop variable.</h3>"
                        },
                        {
                            intro: "<h3>Let's see an example! <i class='eo-32 eo-joy'></i></h3>"
                        },
                        {
                            element: '#example',
                            intro: "<h3>You know the output, right? <i class='eo-32 eo-joy'></i></h3>"
                        },
                        {
                            element: '#example',
                            intro: "<h3>Ye! It will be output <br><code>0<br>1<br>2<br></code></h3>"
                        },
                        {
                            intro: "<h3>OK! Now you learned the basic for loop!</h3>"
                        },
                        {
                            intro: "<h3>In this application, we will focus more on for loop!</h3>"
                        },
                        {
                            element: '#next-step',
                            intro: "<h3>Let's try it yourself! You will get a reward !</h3>",
                            position: 'left'
                        }
                    ]
                }
            };
        },
        methods: {
            startIntro() {
                this.intro.setOptions(this.introConfig);
                this.intro.start();
            },
            startWithSyntaxIntro() {
                this.intro.goToStepNumber(6).start();
            },
            startWithExampleIntro() {
                this.intro.goToStepNumber(8).start();
            },
            nextStep() {
                this.$events.fire('nextStep');
                window.location.href = '/arcades/tutorial/for-loop/start';
            }
        },
        mounted() {
            this.startIntro();
        }
    }
</script>

<style>
    .CodeMirror {
        height: auto;
    }
    .CodeMirror-scroll {
        overflow-y: hidden;
        overflow-x: auto;
    }
</style>