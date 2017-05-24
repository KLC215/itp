<template>
	<el-dialog title="Sign up" v-model="config.show" size="tiny" @close="close('signUpForm')">
		<el-alert
				:title="errors.email"
				type="error"
				show-icon
				:closable="false"
				v-if="errors.email">
		</el-alert>
		<el-alert
				:title="errors.name"
				type="error"
				show-icon
				:closable="false"
				v-if="errors.name">
		</el-alert>
		<el-form :model="signUpForm" :rules="signUpRules" ref="signUpForm">
			<el-form-item label="Name" prop="name">
				<el-input type="text" v-model="signUpForm.name" name="name">
				</el-input>
			</el-form-item>
			<el-form-item label="Email" prop="email">
				<el-input type="text" v-model="signUpForm.email" name="email">
				</el-input>
			</el-form-item>
			<el-form-item label="Password" prop="password">
				<el-input type="password"
						  v-model="signUpForm.password"
						  name="password">
				</el-input>
			</el-form-item>
			<el-form-item label="Confirm Password" prop="confirmPassword">
				<el-input type="password"
						  v-model="signUpForm.confirmPassword"
						  auto-complete="off"
						  name="password_confirmation"
						  @keyup.enter="submit"></el-input>
			</el-form-item>
			<el-form-item>
				<el-button type="primary"
						   native-type="submit"
						   @click.prevent="userSignUp('signUpForm')"
						   @keyup.enter="submit">SIGN UP


				</el-button>
			</el-form-item>
		</el-form>
		<span slot="footer">
    			<el-button type="success" size="mini">Already have Account?</el-button>
  		</span>
	</el-dialog>

</template>

<script>
	import { HOME_URL, SIGNUP_POST_URL } from '../../core/urls';

	export default {
		props: ['config'],

		data() {

			let validateName = (rule, value, callback) => {
				if (value === '') {
					callback(new Error('Please enter your display name!'));
				} else if (value.length < 3) {
					callback(new Error('Name is at least 3 characters!'));
				} else {
					callback();
				}
			};

			let validatePassword = (rule, value, callback) => {
				if (value === '') {
					callback(new Error('Please enter password!'));
				} else if (value.length < 8) {
					callback(new Error('Password is at least 8 characters!'));
				} else {
					if (this.signUpForm.confirmPassword !== '') {
						this.$refs.signUpForm.validateField('confirmPassword');
					}
					callback();
				}
			};

			let validateConfirmPassword = (rule, value, callback) => {
				if (value === '') {
					callback(new Error('Please enter password again!'));
				} else if (value !== this.signUpForm.password) {
					callback(new Error('Password must be the same!'));
				} else {
					callback();
				}
			};

			return {
				signUpForm: new Form({
					name           : '',
					email          : '',
					password       : '',
					confirmPassword: '',
				}),

				signUpRules: {
					name: [
						{
							required : true,
							validator: validateName,
						}
					],

					email: [
						{
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

					password: [
						{
							required : true,
							validator: validatePassword,
							trigger  : 'blur'
						}
					],

					confirmPassword: [
						{
							required : true,
							validator: validateConfirmPassword,
							trigger  : 'blur'
						}
					]
				},

				errors: {
					email: '',
					name : '',
				}
			};
		},
		methods: {

			userSignUp(formName) {
				const self = this;

				this.clearErrors();

				self.$refs[formName].validate((valid) => {
					if (valid) {
						self.signUpForm.post(SIGNUP_POST_URL)
							.then(data => {
								self.close('signUpForm');
								window.location = HOME_URL;
							})
							.catch(error => {
								if (error.email) {
									this.errors.email = error.email[0];
								}
								if (error.name) {
									this.errors.name = error.name[0];
								}
								console.log(error);
								//console.log(self.signUpForm.errors);
							});
					} else {
						return false;
					}
				});
			},

			close(formName) {
				this.resetForm(formName);
				this.clearErrors();
				this.config.show = false;
			},

			resetForm(formName) {
				this.$refs[formName].resetFields();
			},

			clearErrors() {
				this.errors.email = '';
				this.errors.name = '';
			}
		},
	}
</script>

<style scoped>

</style>