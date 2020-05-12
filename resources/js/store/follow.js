const state = {
    followings: '',
    followers: ''
}

const getters = {
    followingsCounts: state => state.followings.length,
    followersCounts: state => state.followers.length
}

const mutations = {
    setFollowings (state, followings) {
        state.followings = followings
    },
    setFollowers (state, followers) {
        state.followers = followers
    }
}

const actions = {

}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
