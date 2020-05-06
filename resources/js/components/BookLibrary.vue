<template>
<div>
<!--    <h3 class="want-books-title"><strong>マイライブラリ</strong></h3>-->
    <div style="padding-top: 50px;">
        <div style="text-align: -webkit-center;">
            <div class="mt-3 new-books-card" v-for="book in books">
                <div class="d-flex flex-row">
                    <div class="font-weight-lighter">
                        <div>
                            <RouterLink class="book_overlay" :to="`/books/${book.id}`">
                                <img class="card-img library-img-size" :src="book.imageLinks" />
                            </RouterLink>
                        </div>
                    </div>
                </div>
            </div>
            <Pagination uri="/" :current-page="currentPage" :last-page="lastPage" />
        </div>
    </div>
</div>
</template>

<style>
    #overlay{
        /*　要素を重ねた時の順番　*/
        z-index:1;

        /*　画面全体を覆う設定　*/
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-color:rgba(0,0,0,0.5);

        /*　画面の中央に要素を表示させる設定　*/
        display: flex;
        align-items: center;
        justify-content: center;

    }

    #content{
        z-index:2;
        width:50%;
        padding: 1em;
        background:#fff;
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
