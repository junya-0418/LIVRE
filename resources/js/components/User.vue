<template>
<div>
    <div class="user-main" style="display:flex;">
        <div class="d-flex flex-row">
            <i class="fas fa-user-circle fa-3x"></i>
        </div>
        <h2 class="h4 card-title ml-2 user-name">
            {{ username }}
        </h2>
    </div>

    <div style="padding-top: 50px;">
        <div style="text-align: -webkit-center;">
            <div class="mt-3 new-books-card" v-for="book in bookLists">
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
            <Pagination :uri="uri" :current-page="currentPage" :last-page="lastPage" />
        </div>
    </div>

    <div>
<!--        <follow-button class="ml-auto"-->
<!--                       :initial-is-followed-by='@json($user->isFollowedBy(Auth::user()))'-->
<!--                       :authorized='@json(Auth::check())'-->
<!--                       :display-button='@json($display_follow_button)'-->
<!--                       :followings-counts="@json($followingsCounts)"-->
<!--                       :followers-counts="@json($followersCounts)"-->
<!--                       endpoint="{{ route('users.follow', ['id' => $user->id]) }}">-->
<!--        </follow-button>-->
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
            Pagination
        },
        data() {
            return {
                bookLists : [],
                uri: '/user/' + this.id,
                username: ''
            }
        },
        computed: {
            ...mapState({
                currentPage: state => state.book.currentPage,
                lastPage: state => state.book.lastPage,
            })
        },
        methods: {
            async fetchMyBooks() {

                const response = await axios.get(`/api/user/${this.id}?page=${this.page}`)
                // console.log(response.data)
                this.bookLists = response.data.mybooks.data
                this.username = response.data.username
                this.$store.commit('book/setCurrentPage', response.data.mybooks.current_page)
                this.$store.commit('book/setLastPage', response.data.mybooks.last_page)
            },
        },
        watch: {
            $route: {
                async handler () {
                    await this.fetchMyBooks()
                },
                immediate: true
            }
        }

    }
</script>

<style>

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
    }


</style>

