<template>
	<transition name="modal">
		<div class="modal-mask" v-show="config.show" :config="config" @click="close">
			<slot></slot>
		</div>
	</transition>


</template>

<script>
	export default {
		props: {
			config: {
				validator(value) {
					return value.hasOwnProperty('show') && typeof value.show === 'boolean';
				}
			}
		},
		methods: {
			close() {
				this.config.show = false;
			}
		},
		created() {
			const self = this;
			document.addEventListener("keydown", (e) => {
				if (self.config.show && e.keyCode == 27) {
					self.close();
				}
			});
		}
	}
</script>

<style scoped>
	/*.modal-mask {*/
		/*position: fixed;*/
		/*z-index: 9998;*/
		/*top: 0;*/
		/*left: 0;*/
		/*width: 100%;*/
		/*height: 100%;*/
		/*background-color: rgba(0, 0, 0, .5);*/
		/*transition: opacity .3s ease;*/
	/*}*/

	.modal-enter, .modal-leave {
		opacity: 0;
	}

	.modal-enter .modal-container,
	.modal-leave .modal-container {
		-webkit-transform: scale(1.1);
		transform: scale(1.1);
	}
</style>