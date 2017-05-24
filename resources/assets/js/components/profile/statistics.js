import { PolarArea } from 'vue-chartjs';

export default PolarArea.extend({

    props: ['data'],

    mounted() {
        this.renderChart(this.data);
    }
})