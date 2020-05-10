<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark navbar-fixed-left" style="background-color: black;">
            <a class="navbar-brand pl-2" href="/"><i class="far fa-sticky-note mr-1"></i>Livre</a>
            <div class="collapse navbar-collapse mt-4">
                <ul class="pl-2" style="list-style: none;">
                    <li class="nav-item mb-3">
                        <RouterLink class="navbar__brand text-light" to="/">
                            ホーム
                        </RouterLink>
                    </li>
                    <li class="nav-item" v-if="isLogin">
                        <RouterLink class="navbar__brand text-light" :to="`/user/${userId}`">
                            マイページ
                        </RouterLink>
                    </li>
                    <li class="nav-item dropdown" style="position: fixed; bottom: 3rem; color: #fff !important;">

                        <div v-if="isLogin">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ username }}</a>
                            <div class="dropdown-menu">
                                <a form="logout-button" href="javascript:void(0);" @click="logout" class="nav-link p-0 pl-2">
                                    ログアウト
                                </a>
<!--                                <button class="button button&#45;&#45;link" @click="logout">Logout</button>-->
                            </div>
                        </div>

                        <div v-else>
                            <RouterLink class="button button--link text-light" to="/login">
                                Login / Register
                            </RouterLink>
                        </div>

                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        computed: {
            isLogin () {
                return this.$store.getters['auth/check']
            },
            username () {
                return this.$store.getters['auth/username']
            },
            userId () {
                return this.$store.getters['auth/userId']
            },
            apiStatus () {
                return this.$store.state.auth.apiStatus
            },
        },
        methods: {
            async logout() {
                // authストアのlogoutアクションを呼び出す
                await this.$store.dispatch('auth/logout')

                // ログインページに移動する
                if(this.apiStatus) {
                    this.$store.commit('message/setContent', {
                        content: 'ログアウトしました',
                        timeout: 6000
                    })
                    this.$router.push('/login')
                }
            }
        }
    }
</script>

<style>
    .navbar-fixed-left {
        width: 300px;
        position: fixed;
        border-radius: 0;
        height: 100%;
        display: block;
        top: 0;
        z-index: 1030;
        left: 0;
        padding-left: 70px;
        border-right: solid 1px #fff;
    }
</style>
