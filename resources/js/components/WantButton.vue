<template>
    <div>
        <div class="mt-4" style="display: flex;">
            <button class="btn-sm shadow-none border border-primary" :class="buttonColor" @click="clickWant">
                <i class="fas fa-book-open mr-2"></i>
                {{ buttonText }}
            </button>
            <div class="wants-counts text-light ml-2 mt-1" @click="openModal">
                {{ wantsCounts }}
            </div>
        </div>

        <Modal v-show="showContent"
               @close-modal="closeModal"
               title="読みたい！したユーザー"
               :items="items"
        >

        </Modal>

    </div>
</template>

<script>
    import {SESSION_EXPIRED, UNAUTHORIZED} from "../util";
    import Modal from "./Modal";

    export default {
        props: {
            id: {
                type: String,
                required: true
            }
        },
        components: {
            Modal
        },
        data() {
            return {
                isWantedBy: false,
                wantsCounts: '',
                showContent: false,
                items: []
            }
        },
        computed: {
            buttonColor() {
                return this.isWantedBy
                    ? 'bg-primary text-white'
                    : 'bg-white'
            },
            buttonText() {
                return this.isWantedBy
                    ? '読みたい！済み'
                    : '読みたい！'
            },
        },
        methods: {
            async initialWantedBy() {
                const response = await axios.get(`/api/wantCheck/${this.id}`)

                if (response.data.check >= 1) {
                    this.isWantedBy = true
                } else {
                    this.isWantedBy = false
                }

                this.wantsCounts = response.data.counts
                this.items = response.data.want_users[0].wants

            },
            clickWant() {
                this.isWantedBy
                    ? this.unwant()
                    : this.want()
            },
            async want() {
                const response = await axios.put(`/api/want/${this.id}`)

                if (response.status === SESSION_EXPIRED) {
                    this.$store.commit('message/setContent', {
                        content: 'セッションの有効期限が切れています\n画面のリロードを行ってください',
                        timeout: 8000
                    })
                    return false
                }

                if (response.status === UNAUTHORIZED) {
                    this.$store.commit('message/setContent', {
                        content: 'ログインを行ってください',
                        timeout: 8000
                    })
                    return false
                }

                this.isWantedBy = true
                this.wantsCounts = response.data.counts
                this.items = response.data.want_users[0].wants
            },
            async unwant() {
                const response = await axios.delete(`/api/want/${this.id}`)

                if (response.status === UNAUTHORIZED) {
                    this.$store.commit('message/setContent', {
                        content: 'ログインを行ってください',
                        timeout: 8000
                    })
                    return false
                }

                this.isWantedBy = false
                this.wantsCounts = response.data.counts
                this.items = response.data.want_users[0].wants
            },
            openModal() {
                this.showContent = true
            },
            closeModal() {
                this.showContent = false
            },
        },
        watch: {
            $route: {
                async handler () {
                    await this.initialWantedBy()
                },
                immediate: true
            }
        }
    }
</script>

<style>
    .hide-button {
        display: none;
    }

    .wants-counts:hover {
        cursor: pointer;
        text-decoration: underline;
    }
</style>
