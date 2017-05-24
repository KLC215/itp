<template>
    <div>
        <el-card class="box-card">
            <div class="text-center">


                <div id="clockdiv">
                    <div>
                        <span class="minutes">{{ timerData.minutes }}</span>
                        <div class="smalltext">Minutes</div>
                    </div>
                    <div>
                        <span class="seconds">{{ timerData.seconds }}</span>
                        <div class="smalltext">Seconds</div>
                    </div>
                </div>
                <el-switch
                        v-model="starter.on"
                        :disabled="starter.disabled"
                        on-color="#ff4949"
                        off-color="#13ce66"
                        on-text="Stop"
                        off-text="Go"
                        @change="handleSwitch">
                </el-switch>
            </div>
        </el-card>
    </div>

</template>

<script>
    import Countdown from './Countdown.vue';
    import { DEDUCT_ITEM_QTY_POST_URL } from '../../../core/urls';

    export default {
        props: ['functional-data'],

        components: {
            Countdown
        },

        data() {
            return {
                minutes: this.functionalData.functional_no,
                starter: {
                    disabled: false,
                    on: false,
                },
                future: null,
                now: null,
                distance: null,
                interval: null,
                timerData: {
                    days: null,
                    hours: null,
                    minutes: '03',
                    seconds: '00',
                },
                time: 0,
                increaseData: {
                    seconds: 0,
                    increase: false,
                }
            };
        },

        methods: {
            timer() {
                this.now = new Date().getTime();
                //console.log(this.now);
                /*if(this.increaseData.increase) {
                 this.now = this.now + this.increaseData.seconds * 10000;
                 //this.now.setSeconds(this.now.getSeconds, + this.increaseData.seconds);
                 this.increaseData.increase = false;
                 }*/

                this.distance = this.future - this.now;

                //this.timerData.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                //this.timerData.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                this.timerData.minutes = Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60)).toString().length === 1
                    ? '0' + Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60))
                    : Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60));
                this.timerData.seconds = Math.floor((this.distance % (1000 * 60)) / 1000).toString().length === 1
                    ? '0' + Math.floor((this.distance % (1000 * 60)) / 1000)
                    : Math.floor((this.distance % (1000 * 60)) / 1000);

                if (this.distance < 0) {
                    clearInterval(this.interval);
                    this.$events.fire('timeIsUp');
                    this.timerData.minutes = '00';
                    this.timerData.seconds = '00';
                    console.log('88');
                }
            },
            handleSwitch() {
                this.$events.fire('showQuestionBlock');
                this.$events.fire('availableItem');
                this.starter.on = true;
                this.starter.disabled = true;
                let dateString = moment().add({
                    minutes: this.minutes,
                    seconds: 1
                }).format('ddd, DD MMM YYYY HH:mm:ss');
                this.future = new Date(dateString).getTime();
                this.interval = setInterval(this.timer, 1000);
            }
        },

        events: {
            increaseTenSeconds(item) {
                const self = this;
                console.log(item);
                // plus 1 for delay
                this.future += (parseInt(item.features.functional_no) + 1) * 1000;

                item.users[0].pivot.quantity -= 1;
                if (item.users[0].pivot.quantity === 0) {
                    this.$events.fire('disableItemButton');
                }
                console.log(item.users[0].pivot.quantity);
                axios.post(DEDUCT_ITEM_QTY_POST_URL, {
                    itemId: item.id,
                    itemName: item.name
                }).then((response) => {
                    if (response.data.success) {
                        self.$message({
                            message: response.data.message,
                            type: 'success'
                        });
                    }
                });
            }
        }

    }
</script>

<style scoped>
    #clockdiv {
        font-family: sans-serif;
        color: #fff;
        display: inline-block;
        font-weight: 100;
        text-align: center;
        font-size: 30px;
    }

    #clockdiv > div {
        padding: 10px;
        border-radius: 3px;
        background: #00BF96;
        display: inline-block;
    }

    #clockdiv div > span {
        padding: 15px;
        border-radius: 3px;
        background: #00816A;
        display: inline-block;
    }

    .smalltext {
        padding-top: 5px;
        font-size: 16px;
    }
</style>