import Router from 'vue-router'
import Home from './components/pages/Home.vue'
import About from './components/pages/About.vue'
import UserRegist1 from './components/pages/UserRegistPage1.vue'
import UserRegist2 from './components/pages/UserRegistPage2.vue'
import Login from './components/pages/Login.vue'
import ChangePass from './components/pages/ChangePassword.vue'
import UserPage from './components/pages/UserPage/UserPage.vue'
import Form_sample from './components/form_sample.vue'
import test_page from './components/pages/test.vue'
import Reserve from './components/ReservePage.vue'
import Confirmation from "./components/ConfirmationPage.vue"
import CompletePage from "./components/CompletePage.vue"
import mainTop from "./components/mainTop.vue"

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
        path: '/about',
        name: 'about',
        component: About
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/change_pass',
        name: 'changePass',
        component: ChangePass,
    },
    {
        path: '/user_regist1',
        name: '新規登録(サンプル1)',
        component: UserRegist1,
    },
    {
      path: '/user_regist2',
      name: '新規登録(サンプル2)',
      component: UserRegist2,
    },
    {
        path: '/user_page',
        name: 'ユーザーページ',
        component: UserPage,
    },
    {
        path: '/form_sample',
        name: 'form_sample',
        component: Form_sample
    },
    {
        path: '/test',
        name: 'test',
        component: test_page
    },
    {
        path: '/reserve',
        name: 'reserve',
        component: Reserve
    },
    {
        path: '/confirmation',
        name: 'confirmation',
        component: Confirmation
    },
    {
        path: "/complete",
        name: "complete",
        component: CompletePage
    },
    {
        path: "/maintop",
        name: "maintop",
        component: mainTop
    }
  ]
});
