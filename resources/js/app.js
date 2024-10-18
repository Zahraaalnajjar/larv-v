import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

// Import components
import App from './components/App.vue';
import ProductList from './components/ProductList.vue';
import ProductForm from './components/ProductForm.vue';
import Product from './components/Product.vue';
import Login from './components/Login.vue';
import onlyList from "./components/onlyList.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [

        { path: '/', component: ProductList },



        { path: '/products/create', component: ProductForm },

        { path: '/products/:id', component: Product },
        { path: '/products/:id/edit', component: ProductForm,props: true },
        { path: '/login', component: Login },
        { path: '/onlyList', component: onlyList },
    ]
});

// Add navigation guard to redirect authenticated users away from the login page
router.beforeEach((to , from, next) => {
    const isAuthenticated = localStorage.getItem('token') !== null;

    if (to.path !== '/login' && !isAuthenticated) {
        // If the user is authenticated and trying to access the login page, redirect to the home page
        next('/login');
    }  else {
        // Otherwise, allow the navigation to proceed
        next();
    }

});

const app = createApp(App);
app.use(router);
app.mount('#app');
