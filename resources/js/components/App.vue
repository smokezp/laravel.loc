<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <router-link to="/" class="navbar-brand">Home</router-link>
                <router-link :to="{ name: 'product' }" class="navbar-brand">Product</router-link>
                <button class="navbar-toggler" type="button" @click="showAuthPanel">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item text-right" v-if="user">
                            {{user.name}}
                        </li>

                        <li class="nav-item">
                            <button @click="showLoginModal = true" v-if="!logged" class="float-right">Login</button>
                        </li>
                        <li class="nav-item">
                            <button @click="showRegisterModal = true" v-if="!logged" class="float-right">Register</button>
                        </li>
                        <li class="nav-item">
                            <button @click="logout" v-if="logged" class="float-right">Logout</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container" v-if="logged">
            <router-view></router-view>
        </div>
        <login v-if="showLoginModal" @close="showLoginModal = false"></login>
        <register v-if="showRegisterModal" @close="showRegisterModal = false"></register>
    </div>

</template>

<script>
    import Login from "./Login";
    import Register from "./Register";
    import User from '../services/User';

    export default {
        data: () => {
            let user = User.getUser();
            return {
                showLoginModal: false,
                showRegisterModal: false,
                user: user,
                logged: user === null ? false : true
            }
        },
        name: "App",
        components: {Register, Login},
        created() {
            this.$root.$on('logged', (logged) => {
                this.logged = logged;
                this.user = User.getUser();
            })

            this.$root.$on('logouted', () => {
                this.logout();
                this.showLoginModal = true;
            })
        },
        methods: {
            logout() {
                User.removeUserData();
                this.logged = false;
                this.user = null;
            },
            showAuthPanel() {
                let authPanel = $('.navbar-collapse');
                if (authPanel.is(":visible")) {
                    authPanel.hide();
                } else {
                    authPanel.show();
                }
            }
        }
    }
</script>
