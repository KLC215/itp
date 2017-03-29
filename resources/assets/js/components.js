import Example from './components/Example.vue';

// Import guest components
import SignIn from './components/guest/SignIn.vue';
import SignUp from './components/guest/SignUp.vue';

// Import game components
import Rating from './components/game/stages/Rating.vue';
import StepsBar from './components/game/stages/StepsBar.vue';
import WhileLoopIntro from './components/game/stages/WhileLoopIntro.vue';
import WhileLoop from './components/game/stages/WhileLoop.vue';
import { codemirror } from 'vue-codemirror';

Vue.component('example', Example);

// Define guest components
Vue.component('sign-in', SignIn);
Vue.component('sign-up', SignUp);

// Define game components
Vue.component('rating', Rating);
Vue.component('while-loop', WhileLoop);
Vue.component('steps-bar', StepsBar);
Vue.component('while-loop-intro', WhileLoopIntro);
Vue.component('codemirror', codemirror);



