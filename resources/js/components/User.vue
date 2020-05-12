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

    <div class="follow-area" style="display: flex;">
        <div class="card-text" style="width: 600px;">
            <div style="position: absolute; margin-left: 70px; display: flex;">
                <div class="text-light follow-text" @click="openModal('followee')">
                    <strong>{{ followingsCounts }}</strong><span style="opacity: 0.7;"> フォロー</span>
                </div>
                <div href="" class="text-light ml-2 follow-text" @click="openModal('follower')">
                    <strong>{{ followersCounts }}</strong><span style="opacity: 0.7;"> フォロワー</span>
                </div>
            </div>
        </div>

        <div>
            <follow-button class="ml-auto"
                           :id="id">
            </follow-button>
        </div>
    </div>

    <Modal v-show="showContent"
           @close-modal="closeModal"
           :title="title"
           :items="items"
    >

    </Modal>

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
            FollowButton,
            Modal
        },
        data() {
            return {
                bookLists : [],
                uri: '/user/' + this.id,
                username: '',
                showContent: false,
                items: [],
                title: ''
            }
        },
        computed: {
            ...mapState({
                followingsCounts () {
                    return this.$store.getters['follow/followingsCounts']
                },
                followersCounts () {
                    return this.$store.getters['follow/followersCounts']
                },
                currentPage: state => state.book.currentPage,
                lastPage: state => state.book.lastPage,
            })
        },
        methods: {
            async fetchMyBooks() {

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
            closeModal() {
                this.showContent = false
            },
        },
        watch: {
            $route: {
                async handler () {
                    await this.fetchMyBooks()
                    this.showContent = false
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

    .follow-text:hover {
        cursor: pointer;
        text-decoration: underline;
    }

</style>

