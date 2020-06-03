<template>
    <div class="pc-main" style="padding: 0; height: 100%; background-color: black;">
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

<style>
    @media (min-width: 980px) {
        html {
            height: 100% !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
        }

        ul {
            list-style: none;
        }

        .pc-main {
            margin-left: 300px;
            display: flex;
        }

        .main {
            background-color: black;
            float: left;
            position: fixed;
            height: 100%;
            color: #ccc;
            border-right: solid 1px #fff;
            width: 722px;
            margin-right: 0px;
        }

        .right-column {
            float: right;
            color: #ccc;
            background-color: black;
            padding: 20px;
            height: 100%;
            overflow-y: scroll;
        }

        .login-user-name {
            margin-top: auto;
            margin-bottom: auto;
            color: #ccc;
        }


        .new-books-card {
            display: inline-flex;
            margin-right: 5px;
            margin-bottom: 50px;
        }

        .new-books-card-right {
            max-width: 100px;
        }

        .newbooks-title {
            margin-top: 50px;
            font-size: 20px;
            opacity: 0.7;
            width: 180px;
        }

        .newbooks-book-title {
            font-size: 18px;
            margin-left: 15px;
        }

        .newbooks-book-author {
            font-size: 15px;
            margin-left: 15px;
        }

        .newbooks-book-publisher {
            font-size: 12px;
            margin-left: 15px;
            opacity: 0.6;
        }

        .library-img-size {
            max-height: 120px;
            max-width: 144px;
            width: 70% !important;
        }
    }

    @media (max-width: 479px) {
        html {
            height: 100% !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
        }

        ul {
            list-style: none;
        }

        .main {
            background-color: black;
            float: left;
            position: fixed;
            height: 100%;
            color: #ccc;
            border-right: solid 1px #fff;
            width: 722px;
            margin-right: 0px;
        }

        .right-column {
            display: none;
        }

        .login-user-name {
            margin-top: auto;
            margin-bottom: auto;
            color: #ccc;
        }


        .new-books-card {
            display: inline-flex;
            margin-right: 5px;
            margin-bottom: 30px;
        }

        .new-books-card-right {
            max-width: 100px;
        }

        .newbooks-title {
            margin-top: 50px;
            font-size: 20px;
            opacity: 0.7;
            width: 180px;
        }

        .newbooks-book-title {
            font-size: 18px;
            margin-left: 15px;
        }

        .newbooks-book-author {
            font-size: 15px;
            margin-left: 15px;
        }

        .newbooks-book-publisher {
            font-size: 12px;
            margin-left: 15px;
            opacity: 0.6;
        }

        .library-img-size {
            max-height: 120px;
            max-width: 144px;
            width: 70% !important;
        }
    }
</style>

