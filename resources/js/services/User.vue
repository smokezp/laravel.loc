<template>

</template>

<script>
    export default {
        name: "User",
        getUser() {
            return JSON.parse(localStorage.getItem('user'));
        },
        setUserData(user, token) {
            localStorage.setItem('token', JSON.stringify(token));
            localStorage.setItem('user', JSON.stringify(user));
        },
        getToken() {
            return JSON.parse(localStorage.getItem('token'));
        }
    }
</script>

<style scoped>

</style>
