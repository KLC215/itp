export default function (Vue) {

	Vue.user = {

		setAuthenticatedUser(data) {
			localStorage.setItem('authUser', data);
		},

		getAuthenticatedUser() {

			let authUser = localStorage.getItem('authUser');

			if (!authUser) {
				return false;
			}

			return authUser;
		}
	};

	Object.defineProperties(Vue.prototype, {
		$user: {
			get() {
				return Vue.user;
			}
		}
	});
}