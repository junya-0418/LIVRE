import { OK, UNAUTHORIZED } from '../util'

const state = {
    books: [],
    currentPage: 0,
    lastPage: 0
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
}

const actions = {
    async fetchBooks (context, data) {
        const response = await axios.get(`/api/books/?page=${data}`)
        context.commit('setBooks', response.data.data)
        context.commit('setCurrentPage', response.data.current_page)
        context.commit('setLastPage', response.data.last_page)
    },
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}