import { createApp } from 'vue'
// import App from './App.vue'
// import AppTest from './AppTest.vue'
import 'jquery'; // Importez jQuery
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.bundle.js'
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'datatables.net'; // Importez DataTables
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

import ContainerApp from './ContainerApp.vue'
// import { createRouter, createWebHistory } from 'vue-router';
import router from './rooter'


const app=createApp(ContainerApp);

app.use(router);
app.mount('#app');

//deconnexion apres certain temp
let inactivityTimeout;

document.addEventListener('mousemove', resetTimer);
document.addEventListener('keypress', resetTimer);

function resetTimer() {
    const access_token = localStorage.getItem('access_token');
    if(access_token){
    clearTimeout(inactivityTimeout);
    inactivityTimeout = setTimeout(logout, 2000000); // 300000 ms = 5 minutes
    }
}

function logout() {
    localStorage.removeItem('access_token');
    // Redirigez l'utilisateur vers la page de connexion ou effectuez toute autre action de déconnexion nécessaire
}

// createApp(ContainerApp).mount('#app')
