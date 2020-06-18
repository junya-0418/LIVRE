<template>
<div style="display: grid;">
    <div >
        <select class="user-select custom-select custom-select-sm" @change="changePath()" ref="element">
            <option :value="`/followers/${userId}`">フォロー中のユーザーの本</option>
            <option v-if="isLogin" value="/">すべてのユーザーの本</option>
        </select>
    </div>

    <div v-if="loading" class="loading" style="text-align: center;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div v-if="!loading" class="book-library-main">
        <div style="text-align: -webkit-center;">
            <div class="mt-3 new-books-card" v-for="book in books">
                <div class="d-flex flex-row">
                    <div class="font-weight-lighter">
                            <RouterLink class="book_overlay" :to="`/books/${book.id}`">
                                <div class="book-item">
                                    <img class="card-img library-img-size" :src="book.imageLinks" />
                                    <div class="mask">
                                    　<div class="caption">{{ book.owner.name }}</div>
                                　   </div>
                                </div>
                            </RouterLink>
                    </div>
                </div>
            </div>
            <div>
                <Pagination uri="/" :current-page="currentPage" :last-page="lastPage" />
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import Pagination from '../components/Pagination.vue'
    import {mapState} from "vuex";

    export default {
        props: {
            page: {
                type: Number,
                required: false,
                default: 1
            }
        },
        components: {
          Pagination
        },
        data() {
            return {
                showContent: false,
                loading: false,
            }
        },
        computed: {
            ...mapState({
                books: state => state.book.followersBooks,
                currentPage: state => state.book.followersCurrentPage,
                lastPage: state => state.book.followersLastPage,
                isLogin () {
                    return this.$store.getters['auth/check']
                },
                userId () {
                    return this.$store.getters['auth/userId']
                },
            }),
        },
        methods: {
            async fetchFollowersBooks () {
                this.loading = true
                await this.$store.dispatch('book/fetchFollowersBooks', {page: this.page, id: this.userId})
                this.loading = false
            },
            changePath() {
                const element = this.$refs.element
                this.$router.push(
                    {
                        path: element.value
                    }
                )
            }
        },
        watch: {
            $route: {
                async handler () {
                    await this.fetchFollowersBooks()
                },
                immediate: true
            }
        }

    }
</script>

<style>
    @media (min-width: 980px) {
        .user-select {
            width: 210px;
            border-radius: 15px;
            float: right;
            margin-right: 30px;
            border-color: rgb(29, 161, 242);
            background-color: rgb(32, 35, 39);
            color: rgb(29, 161, 242) !important;
        }

        .book-library-main {
            padding-top: 50px;
        }

        .book-item {
            position: relative;
        }
        .book-item .caption {
            color: #fff;
            font-size: 14px;
        }
        .book-item .mask {
            width: 100%;
            height: 100%;
            position: absolute;
            opacity: 0;
            overflow: hidden;
        }
        .book-item:hover {
            opacity: 0.8;
        }
        .book-item:hover .mask {
            opacity: 1;
        }
    }

    @media (max-width: 479px) {
        .user-select {
            width: 210px;
            border-radius: 15px;
            float: right;
            margin-right: 30px;
            border-color: rgb(29, 161, 242);
            background-color: rgb(32, 35, 39);
            color: rgb(29, 161, 242) !important;
            margin-top: 90px;
        }

        .book-library-main {
            margin-top: 30px;
            margin-bottom: 50px;
            height: 100%;
        }

        .book-item {
            position: relative;
        }
        .book-item .caption {
            color: #fff;
            font-size: 14px;
        }
        .book-item .mask {
            width: 100%;
            position: absolute;
            opacity: 0;
            overflow: hidden;
        }
        .book-item:hover {
            opacity: 0.8;
        }
        .book-item:hover .mask {
            opacity: 1;
        }

        .loading {
            margin-top: 80px;
        }
    }
</style>
