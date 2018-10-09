<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <router-link to="/" class="navbar-brand">Home</router-link>
                <router-link :to="{ name: 'product' }" class="navbar-brand">Product</router-link>
                <button class="navbar-toggler" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <!--@guest-->

                        <li class="nav-item" v-if="user">
                            <span class="p-3">
                                {{user.name}}
                            </span>
                        </li>

                        <li class="nav-item">
                            <button @click="showLoginModal = true" v-if="!logged">Login</button>
                            <button @click="showRegisterModal = true" v-if="!logged">Register</button>
                            <button @click="logout" v-if="logged">Logout</button>
                            <!--<router-link :to="{ name: 'login' }" >Login</router-link>-->
                            <!--<router-link :to="{ name: 'register' }">Register</router-link>-->
                        </li>

                        <!--<li class="nav-item">-->
                        <!--@if (Route::has('register'))-->
                        <!--<a class="nav-link" href="">Register</a>-->
                        <!--@endif-->
                        <!--</li>-->
                        <!--@else-->
                        <!--<li class="nav-item dropdown">-->
                        <!--<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>-->
                        <!--{{ Auth::user()->name }} <span class="caret"></span>-->
                        <!--</a>-->

                        <!--<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">-->
                        <!--<a class="dropdown-item" href="{{ route('logout') }}"-->
                        <!--onclick="event.preventDefault();-->
                        <!--document.getElementById('logout-form').submit();">-->
                        <!--{{ __('Logout') }}-->
                        <!--</a>-->

                        <!--<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">-->
                        <!--@csrf-->
                        <!--</form>-->
                        <!--</div>-->
                        <!--</li>-->
                        <!--@endguest-->
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <router-view></router-view>
        </div>
        <login v-if="showLoginModal" @close="showLoginModal = false"></login>
        <register v-if="showRegisterModal" @close="showRegisterModal = false"></register>
    </div>

</template>

<script>
    import Login from "./Login";
    import Register from "./Register";

    export default {
        data: () => {
            let user = this.default.methods.getUser();
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
                this.user = this.getUser();
            })
        },
        methods: {
            logout() {
                localStorage.removeItem('user');
                this.logged = false;
                this.user = null;
            },
            getUser() {
                return JSON.parse(localStorage.getItem('user'));
            }
        }
    }
</script>
