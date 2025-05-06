import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
const app = createApp({});
// Register your Vue components here
app.component('app', App);
app.mount('#app');``
