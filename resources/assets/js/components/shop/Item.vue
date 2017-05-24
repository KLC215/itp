<script>
    import ItemQuantity from './ItemQuantity.vue';
    import {SHOP_DEAL_POST_URL} from '../../core/urls';

    export default {
        props: ['attributes', 'owncoin'],

        components: {
            ItemQuantity
        },

        data() {
            return {
                coin: this.owncoin,
                item: this.attributes,
                qty: 1,
            };
        },

        methods: {
            buyItems() {
                const self = this;

                this.$swal({
                    title: "Are you sure?",
                    text: "You want to buy " + self.qty + " " + self.item.display_name + " ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then(() => {
                    axios.post(SHOP_DEAL_POST_URL, {
                        qty: self.qty,
                        itemId: self.item.id
                    }).then((response) => {
                        console.log(response);
                        if (response.data.success) {
                            self.$notify.success({
                                title: 'Success! :)',
                                message: response.data.msg,
                                offset: 80
                            });
                        } else {
                            self.$notify.error({
                                title: 'Fail! :(',
                                message: response.data.msg,
                                offset: 80
                            });
                        }
                    });
                });

            },
        },

        events: {
            changedQty(qty) {
                this.qty = qty;
            }
        }
    }
</script>