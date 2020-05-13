<template>
<div>
<!--    <h3 class="want-books-title"><strong>マイライブラリ</strong></h3>-->
    <div style="padding-top: 50px;">
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
            <Pagination uri="/" :current-page="currentPage" :last-page="lastPage" />
        </div>
    </div>
</div>
</template>

<style>
    .book-item {
        position: relative;
    }
    .book-item .caption {
        color: #fff;
        font-size: 14px;
    }
    .book-item .mask {
        width:			100%;
        height:			100%;
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
                await this.$store.dispatch('book/fetchBooks', this.page)
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
