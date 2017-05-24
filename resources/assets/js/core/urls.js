export const BASE_URL = 'http://loop.lh/';

// Backend route groups
export const ARCADES_URL = BASE_URL + 'arcades/';
export const CHALLENGES_URL = BASE_URL + 'challenges/';

// GET urls
export const HOME_URL = BASE_URL + 'home';
export const SHOP_URL = BASE_URL + 'shop/';
export const GET_AUTH_USER = BASE_URL + 'get-auth-user';
export const TUTORIAL_URL = ARCADES_URL + 'tutorial';
export const LEADERBOARD_URL = BASE_URL + 'leaderboard/';
export const PROFILE_URL = BASE_URL + 'profile/';

// POST urls
export const SIGNIN_POST_URL = BASE_URL + 'login';
export const SIGNUP_POST_URL = BASE_URL + 'register';
export const COMPLETE_STAGE_POST_URL = ARCADES_URL + 'complete';
export const COMPLETE_SINGE_STAGE_POST_URL = ARCADES_URL + 'single-complete';
export const SHOP_DEAL_POST_URL = SHOP_URL + 'deal';
export const HINTS_POST_URL = ARCADES_URL + 'hint';
export const DEDUCT_ITEM_QTY_POST_URL = CHALLENGES_URL + 'item-qty-subtract-1';
export const COMPLETE_CHALLENGE_POST_URL = CHALLENGES_URL + 'complete';