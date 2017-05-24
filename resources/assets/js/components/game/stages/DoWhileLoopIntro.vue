<template>
    <div>
        <div id="explain" class="well">
            <h4>Do while loop executes group of Java statements as long as the boolean condition evaluates to true.</h4>
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
                    "do {\n\t<Block of statements>; \n} while(<boolean condition>);",
                    "int i = 0;\ndo {\n\tSystem.out.println(i);\n\ti++;\n} while(i < 2);"
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
                            intro: "<h3>Let's learn about Do while loop<i class='eo-32 eo-smile'></i></h3>"
                        },
                        {
                            element: '#explain',
                            intro: "<h3>Here is the easiest way to understand the flow of do while loop</h3>"
                        },
                        {
                            intro: "<h3>Simply just remember do while loop will execute 1 time first ! <i class='eo-32 eo-joy'></i></h3>"
                        },
                        {
                            element: '#syntax',
                            intro: "<h3>Here is the syntax of a do while loop</h3>"
                        },
                        {
                            element: '#syntax',
                            intro: "<h3>In Java programming, sometime it's necessary to execute the block of statements at least once before evaluating the boolean condition. <hr>Do while loop is similar to the While loop, but it evaluates the boolean condition after executing the block of the statement.</h3>"
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
                            intro: `<h3>Output will be <code><br>0<br>1</code></h3>`
                        },
                        {
                            element: '#example',
                            intro: "<h3>It is because the code will display <code>i</code> first, execute<code>i = i + 1</code>, and then compare with <code>i < 2</code></code><i class='eo-32 eo-joy'></i></h3>"
                        },
                        {
                            intro: "<h3>OK! Now you learned the basic do while loop!</h3>"
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
                this.intro.goToStepNumber(3).start();
            },
            startWithExampleIntro() {
                this.intro.goToStepNumber(5).start();
            },
            nextStep() {
                this.$events.fire('nextStep');
                window.location.href = '/arcades/tutorial/do-while-loop/start';
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