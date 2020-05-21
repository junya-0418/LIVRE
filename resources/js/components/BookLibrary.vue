<template>
<div>
    <div class="loading" style="text-align: center;">
        <div v-if="loading" class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="book-library-main">
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
            <div v-if="!loading">
                <Pagination uri="/" :current-page="currentPage" :last-page="lastPage" />
            </div>
        </div>
    </div>
</div>
</template>

<style>
    @media (min-width: 980px) {
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
        .book-library-main {
            margin-top: 70px;
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
            margin-top: 90px;
        }
    }
</style>

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
                loading: false
            }
        },
        computed: {
            ...mapState({
                books: state => state.book.books,
                currentPage: state => state.book.currentPage,
                lastPage: state => state.book.lastPage,
            })
        },
        methods: {
            async fetchBooks () {
                this.loading = true
                await this.$store.dispatch('book/fetchBooks', this.page)
                this.loading = false
            },
        },
        watch: {
            $route: {
                async handler () {
                    await this.fetchBooks()
                },
                immediate: true
            }
        }

    }
</script>
