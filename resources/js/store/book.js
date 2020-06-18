import { OK, UNAUTHORIZED } from '../util'

const state = {
    books: [],
    currentPage: 0,
    lastPage: 0,
    followersBooks: [],
    followersCurrentPage: 0,
    followersLastPage: 0
}

const getters = {

}

const mutations = {
    setBooks (state, books) {
        state.books = books
    },
    setCurrentPage (state, currentPage) {
        state.currentPage = currentPage
    },
    setLastPage (state, lastPage) {
        state.lastPage = lastPage
    },
    setFollowersBooks (state, books) {
        state.followersBooks = books
    },
    setFollowersCurrentPage (state, currentPage) {
        state.followersCurrentPage = currentPage
    },
    setFollowersLastPage (state, lastPage) {
        state.followersLastPage = lastPage
    },
}

const actions = {
    async fetchBooks (context, data) {
        const response = await axios.get(`/api/books`,
            {
                params: {
                    // ここにクエリパラメータを指定する
                    page: data // このようにパラメータを付けるとhttpsになる
                }
            })
        context.commit('setBooks', response.data.data)
        context.commit('setCurrentPage', response.data.current_page)
        context.commit('setLastPage', response.data.last_page)
    },

    async fetchFollowersBooks (context, {page, id}) {
        const response = await axios.get(`/api/followingsBooks/${id}`,
            {
                params: {
                    // ここにクエリパラメータを指定する
                    page: page // このようにパラメータを付けるとhttpsになる
                }
            })
        context.commit('setFollowersBooks', response.data.data)
        context.commit('setFollowersCurrentPage', response.data.current_page)
        context.commit('setFollowersLastPage', response.data.last_page)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}
