<template>
    <div>
        <div style="float: right;" :class="hideFollowButton">
            <button class="btn-sm shadow-none border border-primary p-2" :class="buttonColor" @click="clickFollow">
                <i class="mr-1" :class="buttonIcon"></i>
                {{ buttonText }}
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                required: true
            }
        },
        data() {
            return {
                isFollowedBy: false,
            }
        },
        computed: {
            buttonColor() {
                return this.isFollowedBy
                    ? 'bg-primary text-white'
                    : 'bg-white'
            },
            buttonIcon() {
                return this.isFollowedBy
                    ? 'fas fa-user-check'
                    : 'fas fa-user-plus'
            },
            buttonText() {
                return this.isFollowedBy
                    ? 'フォロー中'
                    : 'フォロー'
            },
            hideFollowButton() {
                return parseInt(this.id) === this.$store.getters['auth/userId']
                    ? 'hide-button'
                    : ''
            }
        },
        methods: {
            async initialFollowedBy() {
                const response = await axios.get(`/api/followCheck/${this.id}`)

                if (response.data >= 1) {
                    this.isFollowedBy = true
                } else {
                    this.isFollowedBy = false
                }

            },
            clickFollow() {
                this.isFollowedBy
                    ? this.unfollow()
                    : this.follow()
            },
            async follow() {
                if (this.$store.getters['auth/check'] === false) {
                    this.$store.commit('message/setContent', {
                        content: 'フォローするにはログインを行ってください',
                        timeout: 8000
                    })
                    return false
                }

                const response = await axios.put(`/api/follow/${this.id}`)

                this.isFollowedBy = true
                this.$store.commit('follow/setFollowers', response.data)
            },
            async unfollow() {
                if (this.$store.getters['auth/check'] === false) {
                    this.$store.commit('message/setContent', {
                        content: 'フォロー解除にはログインを行ってください',
                        timeout: 8000
                    })
                    return false
                }
                const response = await axios.delete(`/api/follow/${this.id}`)

                this.isFollowedBy = false
                this.$store.commit('follow/setFollowers', response.data)
            },
        },
        watch: {
            $route: {
                async handler () {
                    await this.initialFollowedBy()
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
