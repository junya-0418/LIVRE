import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import BookLibrary from "./components/BookLibrary";
import BookDetail from "./components/BookDetail";
import User from "./components/User";
import Login from "./components/Login";
import SystemError from './errors/System.vue'
import store from './store'
import BookSearch from "./components/BookSearch";

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: BookLibrary,
        props: route => {
            const page = route.query.page
            return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 }
        }
    },
    {
        path: '/search',
        component: BookSearch
    },
    {
        path: '/books/:id',
        component: BookDetail,
        props: true
    },
    {
        path: '/user/:id',
        component: User,
        props: route => {
            const page = route.query.page
            return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1, id: route.params.id}
        }
    },
    {
        path: '/login',
        component: Login,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next('/')
            } else {
                next()
            }
        }
    },
    {
        path: '/500',
        component: SystemError
    }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    // mode: 'history',
    routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
