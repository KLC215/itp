<script>
    import TopThree from './TopThree.vue';
    import Board from './Board.vue';
    import { LEADERBOARD_URL } from '../../core/urls';

    export default {
        props: ['attributes'],

        components: {
            TopThree,
            Board
        },

        data() {
            return {
                start: 4,
                users: this.attributes,
                topThreeUsers: [],
                remainUsers: [],
                assets: ['exp', 'coin'],
                statistics: ['avg_time', 'time', 'star']
            };
        },

        methods: {
            getTop3Users() {
                this.topThreeUsers = [];
                for (let i = 0; i < 3; i++) {
                    this.topThreeUsers.push(this.users[i]);
                }
            },
            getRemainUsers() {
                this.remainUsers = [];
                for (let i = 3; i < this.users.length; i++) {
                    this.users[i].rank = this.start;
                    this.remainUsers.push(this.users[i]);
                    this.start += 1;
                }
                this.start = 4;
            }
        },

        created() {
            this.getTop3Users();
            this.getRemainUsers();
        },

        mounted() {
            this.$events.fire('sentTop3Data', this.topThreeUsers);
            this.$events.fire('sentRemainData', this.remainUsers);
            this.$events.fire('loadedData', true);
        },

        events: {
            changedTab(tabName) {
                this.$events.fire('clearOldTop3Users');
                this.$events.fire('clearOldRemainUsers');

                const self = this;

                axios.get(LEADERBOARD_URL + tabName)
                     .then((response) => {
                         console.log(response.data);

                         self.users = response.data;

                         self.getTop3Users();
                         self.getRemainUsers();

                         self.$events.fire('sentTop3Data', this.topThreeUsers);
                         self.$events.fire('sentRemainData', this.remainUsers);
                         self.$events.fire('changedCurrentTabName', tabName);

                     });
            }
        }
    }
</script>