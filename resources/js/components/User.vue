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

    <div class="follow-area">
        <div class="card-text">
            <div class="follow-counts">
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

    <div style="margin-left: 60px; display: inline-flex; margin-top: 30px;">
        <select class="user-select2 custom-select custom-select-sm" v-model="selected" ref="element">
            <option value="mybooks">マイライブラリの本</option>
            <option value="wantbooks">読みたい本</option>
        </select>
    </div>

    <UserBooks :page="page" :id="id" v-if="selected === 'mybooks'"></UserBooks>
    <Lists :page="page" :id="id" v-if="selected === 'wantbooks'"></Lists>

</div>
</template>

<script>
    import Pagination from '../components/Pagination.vue'
    import FollowButton from "../components/FollowButton.vue";
    import UserBooks from "./UserBooks";
    import Lists from "./Lists";
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
            Modal,
            UserBooks,
            Lists
        },
        data() {
            return {
                bookLists : [],
                uri: '/user/' + this.id,
                username: '',
                showContent: false,
                items: [],
                title: '',
                loading: false,
                selected: "mybooks"
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
            closeModal() {
                this.showContent = false
            },
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
        .user-select2 {
            width: 210px;
            border-radius: 15px;
            float: right;
            margin-right: 30px;
            border-color: rgb(29, 161, 242);
            background-color: rgb(32, 35, 39);
            color: rgb(29, 161, 242) !important;
        }

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
        .user-select {
            width: 210px;
            border-radius: 15px;
            float: right;
            margin-right: 30px;
            border-color: rgb(29, 161, 242);
            background-color: rgb(32, 35, 39);
            color: rgb(29, 161, 242) !important;
        }

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

