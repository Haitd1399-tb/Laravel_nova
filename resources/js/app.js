import './bootstrap';
import {createApp} from 'vue';

const app = createApp({});

import Navbar from './components/Navbar.vue';
app.component('navbar-item', Navbar);

import Footer from './components/Footer.vue';
app.component('footer-item', Footer);

app.mount('#app');