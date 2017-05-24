<template>
	<el-dialog title="Sign in"
			   v-model="config.show"
			   size="tiny"
			   @close="close('signInForm')"
			   :modal="true"
			   :modal-append-to-body="false">
		<el-alert
				v-if="emailError"
				:title="emailError"
				type="error"
				show-icon
				:closable="false">
		</el-alert>
		<el-form :model="signInForm" :rules="signInRules" ref="signInForm">
			<el-form-item label="Email" prop="email">
				<el-input type="text" v-model="signInForm.email" name="email">
				</el-input>
			</el-form-item>
			<el-form-item label="Password" prop="password">
				<el-input type="password"
						  v-model="signInForm.password"
						  name="password"
						  @keyup.enter="submit">
				</el-input>
			</el-form-item>
			<el-form-item>
				<el-button type="primary"
						   @click.prevent="signIn('signInForm')"
						   @keyup.enter="submit"
						   native-type="submit">LOGIN
				</el-button>
			</el-form-item>
		</el-form>
		<span slot="footer">
    			<el-button type="success" size="mini">No Account?</el-button>
				<el-button :plain="true" type="info" size="mini">Forget password?</el-button>
  		</span>
	</el-dialog>
</template>

<script>
	import { HOME_URL, SIGNIN_POST_URL }from '../../core/urls';

	export default {
		props: ['config'],

		data() {
			return {
				signInForm: new Form({
					email   : '',
					password: '',
				}),

				signInRules: {
					email   : [{
						required: true,
						message : 'Please enter email address!',
						trigger : 'blur'
					},
							   {
								   type   : 'email',
								   message: 'Please enter a correct email address!',
								   trigger: 'blur,change'
							   }
					],
					password: [{
						required: true,
						message : 'Please enter password!',
						trigger : 'blur'
					}]
				},
				emailError : "",
			};
		},
		methods: {
			signIn(formName) {
				const self = this;

				self.emailError = "";

				self.$refs[formName].validate((valid) => {
					if (valid) {
						self.signInForm.post(SIGNIN_POST_URL)
							.then(data => {
								self.close('signInForm');
								window.location = HOME_URL;
							})
							.catch(error => {
								if (error.email) {
									this.emailError = error.email;
								}
								console.log(error);
							});
					} else {
						return false;
					}
				});
			},
			close(formName) {
				this.resetForm(formName);
				this.emailError = "";
				this.config.show = false;
			},
			resetForm(formName) {
				this.$refs[formName].resetFields();
			}
		},
		events : {
			closeForm(formName) {
				this.resetForm(formName);
				this.emailError = "";
				this.config.show = false;
			}
		}

	}

</script>

<style scoped>

</style>