<template>
    <div>
        <div class="pc-nav">
        <nav class="navbar navbar-expand-md navbar-dark navbar-fixed-left" style="background-color: black;">
            <RouterLink class="navbar-brand pl-2" to="/">
                <i class="far fa-sticky-note mr-1"></i>
                LIVRE
            </RouterLink>
            <div class="collapse navbar-collapse mt-4">
                <ul class="pl-2" style="list-style: none;">
                    <li class="nav-item mb-3">
                        <RouterLink class="navbar__brand text-light" to="/">
                            ホーム
                        </RouterLink>
                    </li>
                    <li class="nav-item" v-if="isLogin">
                        <RouterLink class="navbar__brand text-light" :to="`/user/${userId}`">
                            マイライブラリ
                        </RouterLink>
                    </li>
                    <li class="nav-item dropdown" style="position: fixed; bottom: 3rem; color: #fff !important;">

                        <div v-if="isLogin">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ username }}</a>
                            <div class="dropdown-menu p-0" style="border: solid 1px #ccc;">
                                <a form="logout-button" href="javascript:void(0);" @click="logout" class="nav-link pl-2 text-light bg-dark">
                                    ログアウト
                                </a>
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

        <div class="sp-nav">
            <nav class="navbar navbar-expand-md navbar-dar sp-header">
                <!-- SideNav slide-out button -->
                <a href="#" data-activates="slide-out" class="btn btn-dark p-3 button-collapse" style="text-align: left; background-color: black !important;" @click="on = !on"><i
                    class="fas fa-bars"></i></a>
                <div style="text-align: center">
                    <RouterLink class="navbar-brand pl-2 text-light" to="/">
                        <i class="far fa-sticky-note mr-1"></i>
                        LIVRE
                    </RouterLink>
                </div>
            </nav>

            <!-- Sidebar navigation -->
            <div id="slide-out" class="side-nav fixed side-nav-light hamburger" :class="{ active: on }">
                <button type="button" class="close text-primary" aria-label="Close" style="font-size: 30px; margin-top: 20px; margin-right: 10px;" @click="on = !on">
                    <span aria-hidden="true">&times;</span>
                </button>
                    <!-- Side navigation links -->
                    <ul class="collapsible collapsible-accordion" style="margin-top: 70px;">
                        <li>
                            <RouterLink class="navbar__brand text-light" to="/">
                                ホーム
                            </RouterLink>
                        </li>
                        <li class="nav-item mt-3" v-if="isLogin">
                            <RouterLink class="navbar__brand text-light" :to="`/user/${userId}`">
                                マイライブラリ
                            </RouterLink>
                        </li>
                        <li class="nav-item dropdown mt-3" style="position: fixed; bottom: 20px;">
                            <div v-if="isLogin">
                                <a class="nav-link dropdown-toggle text-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ username }}</a>
                                <div class="dropdown-menu p-0" style="border: solid 1px #ccc;">
                                    <a form="logout-button" href="javascript:void(0);" @click="logout" class="nav-link pl-2 text-light bg-dark">
                                        ログアウト
                                    </a>
                                </div>
                            </div>

                            <div v-else>
                                <RouterLink class="button button--link text-light" to="/login">
                                    Login / Register
                                </RouterLink>
                            </div>
                        </li>
                    </ul>
                    <!--/. Side navigation links -->
            </div>
            <!--/. Sidebar navigation -->

            <footer class="sp-footer">
                <RouterLink to="/" :class="{'text-primary': pageIsTop}">
                    <i class="fas fa-book-open"></i>
                </RouterLink>
                <RouterLink to="/search" :class="{'text-primary': pageIsSearch}">
                    <i class="fas fa-search"></i>
                </RouterLink>
            </footer>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                on: false,
                pageIsTop: false,
                pageIsSearch: false
            }
        },
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
            },
        },
        watch: {
            $route: {
                handler () {
                    this.on = false
                    this.pageIsTop = false
                    this.pageIsSearch = false

                    var url = location.href

                    var page = url.split('/')

                    //配列の最後の要素を取得する
                    var last = page[page.length - 1]

                    if (last === '') {
                        this.pageIsTop = true
                    } else if (last === 'search') {
                        this.pageIsSearch = true
                    } else {
                        return
                    }
                },
                immediate: true
            }
        }
    }
</script>

<style>
    .sp-nav {
        display: none;
    }

    .navbar-fixed-left {
        width: 300px;
        position: fixed;
        border-radius: 0;
        height: 100%;
        display: block;
        top: 0;
        z-index: 1;
        left: 0;
        padding-left: 70px;
        border-right: solid 1px #fff;
    }

    @media (max-width: 479px) {
        .sp-nav {
            display: block;
        }

        .pc-nav {
            display: none;
        }

        .sp-header {
            background-color: black;
            border-bottom: solid 1px #ccc;
            position: fixed;
            z-index: 1500;
            width: 100%;
        }

        .hamburger {
            z-index: 3000;
            position: fixed;
            background-color: black;
            height: 100%;
            width: 180px;
            transform: translateX(-100%);
            transition: 0.2s all;
        }

        .active{
            transform: translateX(0) !important;
        }

        .sp-footer {
            background-color: black;
            position: fixed;
            border-top: solid 1px #ccc;
            bottom: 0;
            z-index: 2500;
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .sp-footer a {
            color: #CCCCCC;
        }

    }
</style>
