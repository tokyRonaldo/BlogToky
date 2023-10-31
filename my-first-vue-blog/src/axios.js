// axios.js

import axios from 'axios';

const instance = axios.create({
  baseURL: '', // Remplacez par l'URL de votre API
  withCredentials: true, // Nécessaire pour les cookies avec Sanctum
});

instance.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token'); // Récupérez le token d'authentification depuis le local storage
    if (token) {
      config.headers.Authorization = `Bearer ${token}`; // Ajoutez le token dans l'en-tête Authorization
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);

export default instance;
