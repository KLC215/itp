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
import Item from './components/shop/Item.vue';
import LeaderBoard from './components/leaderboard/LeaderBoard.vue';
import Profile from './components/profile/Profile.vue';
import WhileLoopQuestion from './components/game/stages/WhileLoopQuestion.vue';
import SubStageProgressBar from './components/game/stages/SubStageProgressBar.vue';
import DoWhileLoopIntro from './components/game/stages/DoWhileLoopIntro.vue';
import DoWhileLoopQuestion from './components/game/stages/DoWhileLoopQuestion.vue';
import ForLoopIntro from './components/game/stages/ForLoopIntro.vue';
import ForLoopQuestion from './components/game/stages/ForLoopQuestion.vue';
import Question from './components/game/stages/Question.vue';
import Challenge from './components/game/stages/Challenge.vue';
import Timer from './components/game/stages/Timer.vue';
import HealthBar from './components/game/stages/HealthBar.vue';
import Panel from './components/game/stages/Panel.vue';

Vue.component('example', Example);

// Define guest components
Vue.component('sign-in', SignIn);
Vue.component('sign-up', SignUp);

// Define game components
Vue.component('rating', Rating);
Vue.component('while-loop', WhileLoop);
Vue.component('steps-bar', StepsBar);
Vue.component('while-loop-intro', WhileLoopIntro);
Vue.component('do-while-loop-intro', DoWhileLoopIntro);
Vue.component('for-loop-intro', ForLoopIntro);
Vue.component('while-loop-question', WhileLoopQuestion);
Vue.component('do-while-loop-question', DoWhileLoopQuestion);
Vue.component('for-loop-question', ForLoopQuestion);
Vue.component('question', Question);
Vue.component('codemirror', codemirror);
Vue.component('item', Item);
Vue.component('leaderboard', LeaderBoard);
Vue.component('profile', Profile);
Vue.component('sub-stage-progress-bar', SubStageProgressBar);
Vue.component('challenge', Challenge);
Vue.component('timer', Timer);
Vue.component('health-bar', HealthBar);
Vue.component('panel', Panel);


