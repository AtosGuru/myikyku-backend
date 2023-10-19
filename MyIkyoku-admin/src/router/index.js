import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    scrollBehavior() {
        return window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    mode: 'history',
    base: '/myikyoku',
    routes: [

        // Dashboards
        {
            path: '/',
            name: 'analytics',
            component: () => import('../DemoPages/Dashboards/Analytics.vue'),
        },
        {
            path: '/feed',
            name: 'feed management',
            component: () => import('../DemoPages/AdminPages/Feed.vue'),
        },
        {
            path: '/feed/:id',
            name: 'articles management',
            component: () => import('../DemoPages/AdminPages/Articles.vue'),
        },
    ]
})
