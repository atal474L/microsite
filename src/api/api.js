import axios from 'axios';

/**
 * get posts
 * @returns {Promise}
 */
export function getPosts() {
    return axios({
        method: 'get',
        url: 'api/posts',
    });
}

/**
 * get posts
 * @returns {Promise}
 */
export function getWeather() {
    return axios({
        method: 'post',
        url: 'https://api.weatherapi.com/v1/current.json?key=ea47787e8a214dc59cd104551220903&q=dubai&aqi=no',
    });
}


export default {
    getPosts,
    getWeather,
};
