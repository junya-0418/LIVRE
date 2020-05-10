const state = {
    followingsCounts: '',
    followersCounts: ''
}

const getters = {

}

const mutations = {
    setFollowingsCounts (state, counts) {
        state.followingsCounts = counts
    },
    setFollowersCounts (state, counts) {
        state.followersCounts = counts
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
