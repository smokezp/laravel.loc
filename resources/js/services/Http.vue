<template>

</template>

<script>
    import axios from 'axios';
    import User from './User';

    function request(url, data, method) {
        return new Promise((resolve, reject) => {

            axios({url: '/api/' + url, data: data, method: method,  headers: {
                    'Authorization': 'Bearer ' + User.getToken(),
                },})
                .then(resp => {
                    resolve(resp)
                })
                .catch(err => {
                    reject(err)
                });
        });
    }

    export default {
        name: "Http",
        get(url, data) {
            return request(url, data, 'GET');
        },
        post(url, data) {
            return request(url, data, 'POST');
        },
        delete(url, data = '') {
            return request(url, data, 'DELETE');
        },
        put(url, data) {
            return request(url, data, 'PUT');
        }
    }
</script>

<style scoped>

</style>
