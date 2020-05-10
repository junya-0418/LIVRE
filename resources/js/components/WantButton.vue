<template>
    <div>
        <div class="mt-4" style="display: flex;">
            <button class="btn-sm shadow-none border border-primary" :class="buttonColor" @click="clickWant">
                <i class="fas fa-book-open mr-2"></i>
                {{ buttonText }}
            </button>
            <div class="wants-counts text-light ml-2 mt-1">
                {{ wantsCounts }}
            </div>
        </div>
    </div>
</template>

<script>
    import {UNAUTHORIZED} from "../util";

    export default {
        props: {
            id: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                isWantedBy: false,
                wantsCounts: '',
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

            },
            clickWant() {
                this.isWantedBy
                    ? this.unwant()
                    : this.want()
            },
            async want() {
                const response = await axios.put(`/api/want/${this.id}`)

                if (response.status === UNAUTHORIZED) {
                    this.$store.commit('message/setContent', {
                        content: '読みたいはログイン後にできます',
                        timeout: 8000
                    })
                    return false
                }

                this.isWantedBy = true
                this.wantsCounts = response.data
            },
            async unwant() {
                const response = await axios.delete(`/api/want/${this.id}`)

                if (response.status === UNAUTHORIZED) {
                    this.$store.commit('message/setContent', {
                        content: '読みたい解除はログイン後にできます',
                        timeout: 8000
                    })
                    return false
                }

                this.isWantedBy = false
                this.wantsCounts = response.data
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
</style>
