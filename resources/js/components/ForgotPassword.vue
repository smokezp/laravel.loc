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
                                <div class="card w-100">
                                    <div class="card-body">

                                        <div class="form-group row" v-if="state === send">
                                            <label for="email"
                                                   class="col-sm-4 col-form-label text-md-right">Email</label>
                                            <div class="col-md-6">
                                                <input v-model="email" id="email" type="email" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row" v-if="state === verify">
                                            <label for="token"
                                                   class="col-sm-4 col-form-label text-md-right">Token</label>
                                            <div class="col-md-6">
                                                <input v-model="token" id="token" type="text" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row" v-if="state === reset">
                                            <label for="password"
                                                   class="col-sm-4 col-form-label text-md-right">Password</label>
                                            <div class="col-md-6">
                                                <input v-model="password" id="password" type="password" class="form-control">
                                            </div>
                                            <label for="password_confirmation"
                                                   class="col-sm-4 col-form-label text-md-right">Re password</label>
                                            <div class="col-md-6">
                                                <input v-model="password_confirmation" id="password_confirmation" type="password" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-8 offset-md-4">
                                                <button type="submit" class="btn btn-primary" @click="submit">
                                                    {{message}}
                                                </button>
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
    import Http from '../services/Http';
    let defaultMessage = 'Send Password Reset Link';
    export default {
        name: "ForgotPassword",
        data: () => {
            return {
                message: defaultMessage,
                send: 'send',
                verify: 'verify',
                reset: 'reset',
                state: 'send',
                email: null,
                token: null,
                password: null,
                password_confirmation: null
            }
        },
        methods: {
            close(event) {
                event.preventDefault();
                this.$emit('close');
            },
            submit() {
                switch (this.state) {
                    case this.send:
                        Http.post('password/email', {
                            email: this.email,
                        }).then(response => {
                            if (response.status === 200) {
                                this.state = this.verify;
                                this.message = 'Verify token';
                            }
                        });
                        break;
                    case this.verify:
                        Http.post('password/token', {
                            token: this.token,
                        }).then(response => {
                            if (response.status === 200) {
                                this.state = this.reset;
                                this.message = 'Reset password';
                            }
                        });
                        break;
                    case this.reset:
                        Http.post('password/reset', {
                            token: this.token,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                        }).then(response => {
                            if (response.status === 200) {
                                this.message = defaultMessage;
                                this.state = this.reset;
                            }
                        });
                        break;
                }


            }
        },
        directives: {
            ClickOutside
        }
    }
</script>

<style scoped>

</style>
