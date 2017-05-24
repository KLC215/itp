export function transferToSeconds(time) {
    let splitedTime = time.split(':');
    console.log(splitedTime);
    return (+splitedTime[0]) * 60 * 60 + (+splitedTime[1]) * 60 + (+splitedTime[2]);
}

export function transferSecondsToPercent(seconds) {
    const standards = [15, 20, 30, 40, 50];

    let i = 0;

    _.forEach(standards, (item, index) => {
        if (item >= seconds) {
            i = index;
        }
    });

    let result = Math.floor(100 - (( seconds / standards[i] ) * 100)) >= 0;

    return result
        ? Math.floor(100 - (( seconds / standards[i] ) * 100))
        : 100;
}

export function transferTimeToPercent(time) {
    // Time to seconds
    const standards = [1800, 3600, 5400, 7200, 9000];

    let i = 0;

    _.forEach(standards, (item, index) => {
        if (item >= time) {
            i = index;
        }
    });

    let result = Math.floor(100 - (( time / standards[i] ) * 100)) >= 0;

    return result
        ? Math.floor(100 - (( time / standards[i] ) * 100))
        : 100;
}

export function transferStarToPercent(star) {
    // Time to seconds
    const standards = [25, 50, 75, 100, 150];

    let i = 0;

    _.forEach(standards, (item, index) => {
        if (item >= star) {
            i = index;
        }
    });

    let result = Math.floor(100 - (( star / standards[i] ) * 100)) >= 0;

    return result
        ? Math.floor(100 - (( star / standards[i] ) * 100))
        : 100;
}