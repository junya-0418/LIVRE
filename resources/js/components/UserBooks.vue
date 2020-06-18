<template>
<div>

    <div v-if="loading" :class="{'loading': loading}" style="text-align: center;">
        <div class="spinner-border text-primary" role="status">
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
                uri: '/user/' + this.id,
                username: '',
                showContent: false,
                items: [],
                title: '',
                loading: false
            }
        },
        computed: {
            ...mapState({
                currentPage: state => state.book.currentPage,
                lastPage: state => state.book.lastPage,
                userId () {
                    return this.$store.getters['auth/userId']
                },
            })
        },
        methods: {
            async fetchMyBooks() {

                this.loading = true

                const response = await axios.get(`/api/user/${this.id}`,
                    {
                        params: {
                            page: this.page
                        }
                    })

                this.bookLists = response.data.mybooks.data
                this.username = response.data.username
                this.$store.commit('follow/setFollowings', response.data.followings)
                this.$store.commit('follow/setFollowers', response.data.followers)
                this.$store.commit('book/setCurrentPage', response.data.mybooks.current_page)
                this.$store.commit('book/setLastPage', response.data.mybooks.last_page)

                this.loading = false
            },
            openModal(data) {
                this.showContent = true
                if (data === 'followee') {
                    this.title = 'フォロー中'
                    this.items = this.$store.state.follow.followings
                } else {
                    this.title = 'フォロワー'
                    this.items = this.$store.state.follow.followers
                }

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
                    this.showContent = false
                    await this.fetchMyBooks()
                },
                immediate: true
            }
        }

    }
</script>

<style>
    @media (min-width: 980px) {
        .user-main {
            margin-top: 50px;
            width: 600px;
            color: #CCCCCC;
            margin-left: auto;
            margin-right: auto;
        }

        .user-name {
            padding-top: 9px;
        }

        .follow-area {
            margin-top: 20px;
            display: inline-block;
            width: 700px;
        }

        .follow-counts {
            position: absolute;
            margin-left: 70px;
            display: flex;
        }

        .follow-text:hover {
            cursor: pointer;
            text-decoration: underline;
        }

        .users-books {
            padding-top: 50px;
        }
    }

    @media (max-width: 479px) {
        .user-main {
            margin-top: 90px;
            color: #CCCCCC;
            margin-left: 70px;
        }

        .user-name {
            padding-top: 9px;
        }

        .follow-area {
            margin-top: 20px;
        }

        .follow-counts {
            margin-left: 70px;
            display: flex;
        }

        .follow-text:hover {
            cursor: pointer;
            text-decoration: underline;
        }

        .users-books {
            padding-top: 30px;
        }
    }


</style>

