<template>
    <div class="container" style="padding: 0; height: 100%; display: flex;">
        <Nav />
        <main class="col-md-8" style="padding: 0;">
            <div style="height: 100%; background-color: black; border-right: solid 1px #fff;">
                <Message />
                <RouterView />
            </div>
        </main>
        <div class="right-column col-md-4">
            <BookSearch />
        </div>
    </div>
</template>

<script>
    import { INTERNAL_SERVER_ERROR } from './util'
    import Nav from './components/Nav.vue'
    import BookSearch from './components/BookSearch.vue'
    import Login from "./components/Login.vue";
    import Message from "./components/Message.vue";

    export default {
        components: {
            Nav,
            BookSearch,
            Login,
            Message
        },
        computed: {
            errorCode () {
                return this.$store.state.error.code
            }
        },
        watch: {
            errorCode: {
                handler (val) {
                    if (val === INTERNAL_SERVER_ERROR) {
                        this.$router.push('/500')
                    }
                },
                immediate: true
            },
            $route () {
                this.$store.commit('error/setCode', null)
            }
        }
    }
</script>

