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
                type: String,
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
                const response = await axios.put(`/api/follow/${this.id}`)

                this.isFollowedBy = true
                this.$store.commit('follow/setFollowersCounts', response.data)
            },
            async unfollow() {
                const response = await axios.delete(`/api/follow/${this.id}`)

                this.isFollowedBy = false
                this.$store.commit('follow/setFollowersCounts', response.data)
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
