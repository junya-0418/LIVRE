import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import error from './error'
import message from './message'
import book from './book'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        auth,
        error,
        message,
        book
    }
})

export default store
