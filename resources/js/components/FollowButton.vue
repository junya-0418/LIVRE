<template>
    <div>
        <div style="float: right;">
            <button class="btn-sm shadow-none border border-primary p-2" :class="[buttonColor, buttonShow]" @click="clickFollow">
                <i class="mr-1" :class="buttonIcon"></i>
                {{ buttonText }}
            </button>
        </div>

        <div class="follow-area">
            <div class="card-text">
                <a href="" class="text-muted">
                    {{ followingsCounts}} フォロー
                </a>
                <a href="" class="text-muted">
                    {{ followersCounts }} フォロワー
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            initialIsFollowedBy: {
                type: Boolean,
                default: false,
            },
            authorized: {
                type: Boolean,
                default: false,
            },
            endpoint: {
                type: String,
            },
            displayButton: {
                type: Boolean,
                default: true
            },
            followingsCounts: {
                default: 0
            },
            followersCounts: {
                default: 0
            },
        },
        data() {
            return {
                isFollowedBy: this.initialIsFollowedBy,
                isSameUser: this.displayButton
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
            buttonShow() {
                return this.isSameUser
                    ? 'd-block'
                    : 'd-none'
            }
        },
        methods: {
            clickFollow() {
                if (!this.authorized) {
                    alert('フォロー機能はログイン中のみ使用できます')
                    return
                }

                this.isFollowedBy
                    ? this.unfollow()
                    : this.follow()
            },
            async follow() {
                const response = await axios.put(this.endpoint)

                this.isFollowedBy = true
                this.followersCounts = response.data
            },
            async unfollow() {
                const response = await axios.delete(this.endpoint)

                this.isFollowedBy = false
                this.followersCounts = response.data
            },
        },
    }
</script>
