<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container" v-click-outside="close">

                    <div class="modal-header">
                        <slot name="header">
                            Register
                        </slot>
                        <a href="#" class="float-right" @click="close">X</a>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <div class="row justify-content-center">
                                <div class="card w-100">
                                    <div class="card-body">

                                        <div class="form-group row">
                                            <label for="name"
                                                   class="col-md-4 col-form-label text-md-right">Name</label>
                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control" v-model="name">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label
                                                    text-md-right">E-Mail Address</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email"
                                                       class="form-control"
                                                       name="email" v-model="email">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label
                                                text-md-right">Password</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control"
                                                       v-model="password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm"
                                                   class="col-md-4 col-form-label text-md-right"
                                            >Confirm Password</label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password"
                                                       class="form-control" v-model="password_confirmation">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary" @click="submit">
                                                    Register
                                                </button>

                                                <a class="btn btn-link" href="" @click="showLoginModal">
                                                    Already have account?
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </slot>
                    </div>
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
        name: "Register",
        data: () => {
            return {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            }
        },
        methods: {
            close(event) {
                event.preventDefault();
                this.$emit('close');
            },
            showLoginModal() {
                event.preventDefault();
                this.$root.$emit('show-modal', 'login');
            },
            submit() {
                Http.post('register', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                }).then(response => {
                    let logged;
                    if (response.status === 200) {
                        User.setUserData(response.data.user, response.data.token);
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
