<template>
    <div>
        <div id="explain" class="well">
            <h4>While loop executes group of Java statements as long as the boolean condition evaluates to true.</h4>
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
                    "while ( boolean_expression ) {\n\t//Statement \n}",
                    "int i = 0; \nwhile ( i < 2 ) {\n\t System.out.print(i); \n}"
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
                            intro: "<h3>Hello World! <i class='eo-32 eo-smile'></i></h3>"
                        },
                        {
                            intro: "<h3>Welcome to the first chapter of looping! <i class='eo-32 eo-tada'></i></h3>"
                        },
                        {
                            intro: "<h3>You will learn about <b>while loop</b> in here! <i class='eo-32 eo-tada'></i></h3>"
                        },
                        {
                            intro: "<h3>Let get start to it! <i class='eo-32 eo-grin'></i></h3>"
                        },
                        {
                            element: '#explain',
                            intro: "<h3>Here is the easiest way to understand the flow of while loop</h3>"
                        },
                        {
                            intro: "<h3>Easy enough? <i class='eo-32 eo-joy'></i></h3>"
                        },
                        {
                            element: '#syntax',
                            intro: "<h3>Here is the syntax of a while loop</h3>"
                        },
                        {
                            element: '#syntax',
                            intro: "<h3>Block of statements is any valid Java code. <hr>Boolean condition is any valid Java expression that evaluates to boolean value. <hr>Braces are options if there is only one statement to be executed.</h3>"
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
                            intro: "<h3>Ye! It will be output <br><b>01</b></h3>"
                        },
                        {
                            element: '#example',
                            intro: "<h3>It is because <br>when <code>i = 2</code>, <code>2 < 2</code>is not true <i class='eo-32 eo-joy'></i></h3>"
                        },
                        {
                            intro: "<h3>OK! Now you learned the basic while loop!</h3>"
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
                window.location.href = '/arcades/tutorial/while-loop/start';
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