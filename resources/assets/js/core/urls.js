const BASE_URL = 'http://itp.lh/';

// Backend route groups
const ARCADES_URL = BASE_URL + 'arcades/';

// GET urls
const HOME_URL = BASE_URL + 'home';
const GET_AUTH_USER = BASE_URL + 'get-auth-user';
const TUTORIAL_URL = ARCADES_URL + 'tutorial';

// POST urls
const SIGNIN_POST_URL = BASE_URL + 'login';
const SIGNUP_POST_URL = BASE_URL + 'register';
const COMPLETED_STAGE_POST_URL = ARCADES_URL + 'completed-stage';

window.BASE_URL = BASE_URL;
window.SIGNIN_POST_URL = SIGNIN_POST_URL;
window.SIGNUP_POST_URL = SIGNUP_POST_URL;
window.HOME_URL = HOME_URL;
window.GET_AUTH_USER = GET_AUTH_USER;
window.COMPLETED_STAGE_POST_URL = COMPLETED_STAGE_POST_URL;
window.TUTORIAL_URL = TUTORIAL_URL;