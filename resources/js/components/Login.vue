<template>
    <div>
        <div class="container--small" style="padding-top: 100px;">
            <ul class="tab text-light" style="display: flex; justify-content: center;">
                <li class="tab__item mr-5" :class="{'tab__item--active': tab === 1 }" @click="tab = 1">ログイン</li>
                <li class="tab__item mr-5" :class="{'tab__item--active': tab === 2 }" @click="tab = 2">会員登録</li>
            </ul>

            <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6" v-show="tab === 1">
                <div class="card mt-3">
                    <div class="card-body text-center" style="background-color: aliceblue;">
                        <div class="h3 card-title text-center mt-2">ログイン</div>
                        <div class="card-text">
                            <form @submit.prevent="login">

                                <div v-if="loginErrors" class="card-text text-left alert alert-danger">
                                    <ul v-if="loginErrors.email">
                                        <li v-for="msg in loginErrors.email" :key="msg">{{ msg }}</li>
                                    </ul>
                                    <ul v-if="loginErrors.password">
                                        <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
                                    </ul>
                                </div>

                                <div class="md-form">
                                    <label for="login-email">Email</label>
                                    <input type="text" class="form__item form-control" id="login-email" v-model="loginForm.email">
                                </div>

                                <div class="md-form">
                                    <label for="login-password">Password</label>
                                    <input type="password" class="form__item form-control" id="login-password" v-model="loginForm.password">
                                </div>

                                <div class="form__button">
                                    <button class="btn btn-block blue-gradient mt-2 mb-2" type="submit">ログイン</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6" v-show="tab === 2">
                <div class="card mt-3">
                    <div class="card-body text-center" style="background-color: aliceblue;">
                        <div class="h3 card-title text-center mt-2">会員登録</div>
                        <div class="card-text">
                            <form @submit.prevent="register">

                                <div v-if="registerErrors" class="card-text text-left alert alert-danger">
                                    <ul v-if="registerErrors.name">
                                        <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
                                    </ul>
                                    <ul v-if="registerErrors.email">
                                        <li v-for="msg in registerErrors.email" :key="msg">{{ msg }}</li>
                                    </ul>
                                    <ul v-if="registerErrors.password">
                                        <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
                                    </ul>
                                    <ul v-if="registerErrors.password_confirmation">
                                        <li v-for="msg in registerErrors.password_confirmation" :key="msg">{{ msg }}</li>
                                    </ul>
                                </div>

                                <div class="md-form">
                                    <label for="register-email">Name</label>
                                    <input type="text" class="form__item form-control" id="register-name" v-model="registerForm.name">
                                </div>

                                <div class="md-form">
                                    <label for="register-email">Email</label>
                                    <input type="text" class="form__item form-control" id="register-email" v-model="registerForm.email">
                                </div>

                                <div class="md-form">
                                    <label for="register-password">Password</label>
                                    <input type="password" class="form__item form-control" id="register-password" v-model="registerForm.password">
                                </div>

                                <div class="md-form">
                                    <label for="register-password">Password Confirmation</label>
                                    <input type="password" class="form__item form-control" id="register-password-confirmation" v-model="registerForm.password_confirmation">
                                </div>

                                <div class="form__button">
                                    <button class="btn btn-block blue-gradient mt-2 mb-2" type="submit">会員登録</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    export default {
        data () {
            return {
                tab: 1,
                loginForm: {
                    email: '',
                    password: ''
                },
                registerForm: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                }
            }
        },
        computed: {
            ...mapState({
                apiStatus: state => state.auth.apiStatus,
                loginErrors: state => state.auth.loginErrorMessages,
                registerErrors: state => state.auth.registerErrorMessages
            })
        },
        methods: {
            async login () {
                // authストアのloginアクションを呼び出す
                await this.$store.dispatch('auth/login', this.loginForm)

                // トップページに移動する
                if (this.apiStatus) {
                    this.$store.commit('message/setContent', {
                        content: 'ログインしました',
                        timeout: 6000
                    })

                    this.$router.push('/')
                }
            },
            async register () {
                // authストアのresigterアクションを呼び出す
                await this.$store.dispatch('auth/register', this.registerForm)

                // トップページに移動する
                if (this.apiStatus) {
                    this.$store.commit('message/setContent', {
                        content: 'ログインしました',
                        timeout: 6000
                    })
                    this.$router.push('/')
                }
            },
            clearError() {
                this.$store.commit('auth/setLoginErrorMessages', null)
                this.$store.commit('auth/setRegisterErrorMessages', null)
            }
        },
        created () {
            this.clearError()
        }
    }
</script>

<style scoped>
    .tab__item:hover {
        cursor: pointer;
    }

    .tab__item--active {
        border-bottom: solid 3px #0C9A9A;
    }
</style>
