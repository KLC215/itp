class StarFormula {

    constructor(seconds, errorRatio) {

        this.standards = [
            50000, 40000, 30000, 20000, 15000 //milliseconds
        ];
        this.seconds = seconds;
        this.errorRatio = errorRatio;
        this.stars = 5;
        this.count = 0;

        this.startFormula();
    }

    startFormula() {
        this.calculateStars();

        if (this.errorRatio > 0) {
            this.hasErrorRatio();
        }
    }

    hasErrorRatio() {
        switch (this.errorRatio) {
            case 1:
                this.stars -= 0.5;
                break;
            case 2:
            case 3:
            case 4:
                this.stars -= 1;
                break;
        }
    }

    calculateStars() {

        for(let i=0; i<this.standards.length; i++) {
            console.log(this.standards[i]);
            if (this.seconds <= this.standards[i]) {
                this.count += 1;
            }
        }
        this.stars = this.count;
    }

    getStars() {
        return this.stars;
    }

}

export default StarFormula;