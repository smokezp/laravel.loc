<template>

</template>

<script>
    export default {
        name: "User",
        getUser() {
            return JSON.parse(localStorage.getItem('user'));
        },
        setUser(user) {
            localStorage.setItem('user', JSON.stringify(user));
        }
    }
</script>

<style scoped>

</style>
