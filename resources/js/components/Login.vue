<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container" v-click-outside="close">

                    <div class="modal-header">
                        <slot name="header">
                            Login
                        </slot>
                        <a href="#" class="float-right" @click="close">X</a>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <div class="row justify-content-center">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group row">
                                            <label for="email"
                                                   class="col-sm-4 col-form-label text-md-right">Email</label>
                                            <div class="col-md-6">
                                                <input v-model="email" id="email" type="email" class="form-control">

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password"
                                                   class="col-md-4 col-form-label text-md-right">Password</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control"
                                                       v-model="password">
                                            </div>
                                        </div>

                                        <!--<div class="form-group row">-->
                                        <!--<div class="col-md-6 offset-md-4">-->
                                        <!--<div class="form-check">-->
                                        <!--<input class="form-check-input" type="checkbox"-->
                                        <!--name="remember" id="remember">-->

                                        <!--<label class="form-check-label" for="remember">-->
                                        <!--Remember Me-->
                                        <!--</label>-->
                                        <!--</div>-->
                                        <!--</div>-->
                                        <!--</div>-->

                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-primary" @click="submit">
                                                    Login
                                                </button>

                                                <!--<a class="btn btn-link" href="">-->
                                                <!--Forgot Your Password?-->
                                                <!--</a>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </slot>
                    </div>

                    <!--<div class="modal-footer">-->
                    <!--<slot name="footer">-->
                    <!--default footer-->
                    <!--<button class="modal-default-button" @click="$emit('close')">-->
                    <!--OK-->
                    <!--</button>-->
                    <!--</slot>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import ClickOutside from 'vue-click-outside'
    import User from '../services/User';
    import Http from '../services/Http';

    export default {
        name: "Login",
        data: () => {
            return {
                email: null,
                password: null,
            }
        },
        methods: {
            close(event) {
                event.preventDefault();
                this.$emit('close');
            },
            submit() {
                Http.post('login', {
                    email: this.email,
                    password: this.password,
                }).then(response => {
                    let logged;
                    if (response.status === 200) {
                        User.setUser(response.data.data.user);
                        this.$emit('close');
                        logged = true;
                    } else {
                        logged = false;
                    }
                    this.$root.$emit('logged', logged)
                });
            }
        },
        directives: {
            ClickOutside
        }
    }
</script>

<style scoped>

</style>
