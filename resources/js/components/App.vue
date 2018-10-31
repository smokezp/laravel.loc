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
                            <button @click="showModal = login" v-if="!logged" class="float-right">Login</button>
                        </li>
                        <li class="nav-item">
                            <button @click="showModal = register" v-if="!logged" class="float-right">Register</button>
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
        <login v-if="showModal === login" @close="hideModal"></login>
        <register v-if="showModal === register" @close="hideModal"></register>
        <forgot-password v-if="showModal === password" @close="hideModal"></forgot-password>
    </div>

</template>

<script>
    import Login from "./Login";
    import Register from "./Register";
    import ForgotPassword from "./ForgotPassword";
    import User from '../services/User';
    import Http from '../services/Http';

    export default {
        data: () => {
            let user = User.getUser();
            return {
                login: 'login',
                register: 'register',
                password: 'password',
                showModal: null,
                user: user,
                logged: user === null ? false : true
            }
        },
        name: "App",
        components: {
            Register,
            Login,
            ForgotPassword
        },
        created() {
            this.$root.$on('logged', (logged) => {
                this.logged = logged;
                this.user = User.getUser();
            });

            this.$root.$on('logouted', () => {
                this.logout();
                this.showModal = this.login;
            });

            this.$root.$on('show-modal', (modal) => {
                this.showModal = modal;
            });

        },
        methods: {
            logout() {
                Http.post('logout');
                User.removeUserData();
                this.logged = false;
                this.user = null;
            },
            hideModal() {
                this.showModal = null;
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
