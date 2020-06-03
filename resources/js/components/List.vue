<template>
<div>
    <div class="lists-user-main" style="display:flex;" v-show="username">
        <h2 class="h4 card-title ml-2 user-name">
            {{ username }}さんが読みたい本
        </h2>
    </div>

    <div :class="{'loading': loading}" style="text-align: center;">
        <div v-if="loading" class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="users-books">
        <div style="text-align: -webkit-center;">
            <div class="mt-3 new-books-card" v-for="book in bookLists">
                <div class="d-flex flex-row">
                    <div class="font-weight-lighter">
                        <div class="book-item">
                            <RouterLink class="book_overlay" :to="`/books/${book.id}`">
                                <img class="card-img library-img-size" :src="book.imageLinks" />
                                <div class="mask">
                                　<div class="caption">{{ book.owner.name }}</div>
                            　   </div>
                            </RouterLink>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="!loading">
                <Pagination :uri="uri" :current-page="currentPage" :last-page="lastPage" />
            </div>
        </div>
    </div>

</div>
</template>

<script>
    import Pagination from '../components/Pagination.vue'
    import FollowButton from "../components/FollowButton.vue";
    import Modal from "./Modal";
    import { mapState } from 'vuex'

    export default {
        props: {
            id: {
                type: String,
                required: true,
            },
            page: {
                type: Number,
                required: false,
                default: 1
            }
        },
        components: {
            Pagination,
        },
        data() {
            return {
                bookLists : [],
                uri: '/lists/' + this.id,
                username: '',
                showContent: false,
                loading: false
            }
        },
        computed: {
            ...mapState({
                currentPage: state => state.book.currentPage,
                lastPage: state => state.book.lastPage,
            })
        },
        methods: {
            async fetchLists() {

                this.loading = true

                const response = await axios.get(`/api/lists/${this.id}`,
                    {
                        params: {
                            page: this.page
                        }
                    })

                this.bookLists = response.data.mybooks.data
                this.username = response.data.username
                this.$store.commit('book/setCurrentPage', response.data.mybooks.current_page)
                this.$store.commit('book/setLastPage', response.data.mybooks.last_page)

                this.loading = false
            },
        },
        watch: {
            $route: {
                async handler () {
                    this.showContent = false
                    await this.fetchLists()
                },
                immediate: true
            }
        }

    }
</script>

<style>
    @media (min-width: 980px) {
        .lists-user-main {
            margin-top: 50px;
            width: 600px;
            color: #CCCCCC;
            margin-left: auto;
            margin-right: auto;
        }

        .user-name {
            padding-top: 9px;
        }

        .users-books {
            padding-top: 50px;
        }
    }

    @media (max-width: 479px) {
        .lists-user-main {
            margin-top: 90px;
            color: #CCCCCC;
            margin-left: 50px;
        }

        .user-name {
            padding-top: 9px;
        }

        .users-books {
            padding-top: 30px;
        }
    }


</style>

