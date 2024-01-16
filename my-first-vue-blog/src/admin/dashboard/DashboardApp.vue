<template>

        <H4 class="mb-4">Monblog</H4>
        <ol class="list-unstyled ">
            <li class="mb-2">
            <b><router-link class="nav-link menu-article-index"  :to="{ name: 'app_home' }">
            <i class="bi bi-arrow-counterclockwise"></i>  Revenir au site
            </router-link></b>
            </li>
            <li>
                <a :class="{ 'active': isActive(['dashboard_article','dashboard_article_create','dashboard_article_edit']) , 'nav-link' : !isActive(['dashboard_article','dashboard_article_create','dashboard_article_edit']) }" class=" menu-article d-flex justify-content-between" href="#articleMenu" data-bs-toggle="collapse">
                <span><i class="bi bi-newspaper"></i>  Articles </span><i class="bi bi-caret-down"></i>
                </a> 
                <div class="collapse" id="articleMenu">
                    <ul class="list-unstyled" style="margin-left: 15px;">
                        <li class="nav-item d-flex" >
                          <router-link :class="{ 'active': isActive(['dashboard_article']) , 'nav-link' : !isActive(['dashboard_article']) }" class=" menu-article-index"  :to="{ name: 'dashboard_article' }">
                          <i class="bi bi-list-ul"></i>  Articles
                          </router-link>
                        </li>
                        <li class="nav-item d-flex">
                          <router-link @click="ajouterArticle" :class="{ 'active': isActive(['dashboard_article_create']) , 'nav-link' : !isActive(['dashboard_article_create']) }" class=" menu-article-create" :to="{ name: 'dashboard_article_create' , params: { method :'create' } }">
                          <i class="bi bi-plus-lg"></i>  Ajouter Article
                          </router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a :class="{ 'active': isActive(['dashboard_categorie','dashboard_categorie_create','dashboard_categorie_edit']) , 'nav-link' : !isActive(['dashboard_categorie','dashboard_categorie_create','dashboard_categorie_edit']) }" class=" menu-categorie d-flex justify-content-between" href="#categorieMenu" data-bs-toggle="collapse">
                    <span><i class="bi bi-card-list"></i>  Categories </span><i class="bi bi-caret-down"></i>
                </a> 
                <div class="collapse" id="categorieMenu">
                    <ul class="list-unstyled" style="margin-left: 15px;">
                        <li class="nav-item d-flex" >                           
                            <router-link :class="{ 'active': isActive(['dashboard_categorie']) , 'nav-link' : !isActive(['dashboard_categorie']) }" class=" menu-categorie-index" :to="{ name: 'dashboard_categorie' }">
                            <i class="bi bi-list-ul"></i>  Categories
                            </router-link>
                        </li>
                        <li class="nav-item d-flex">
                            <router-link :class="{ 'active': isActive(['dashboard_categorie_create']) , 'nav-link' : !isActive(['dashboard_categorie_create']) }" class="menu-categorie-create" @click="ajouterCategorie" :to="{ name: 'dashboard_categorie_create' , params: { method :'create' } }">
                            <i class="bi bi-plus-lg"></i>  Ajouter categorie
                            </router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a :class="{ 'active': isActive(['dashboard_media','dashboard_media_create','dashboard_media_edit']) , 'nav-link' : !isActive(['dashboard_media','dashboard_media_create','dashboard_media_edit']) }" class=" menu-media d-flex justify-content-between" href="#mediaMenu" data-bs-toggle="collapse">
                    <span><i class="bi bi-card-list"></i>  Media </span><i class="bi bi-caret-down"></i>
                </a> 
                <div class="collapse" id="mediaMenu">
                    <ul class="list-unstyled" style="margin-left: 15px;">
                        <li class="nav-item d-flex" >                           
                            <router-link :class="{ 'active': isActive(['dashboard_media']) , 'nav-link' : !isActive(['dashboard_media']) }" class="menu-media-index" :to="{ name: 'dashboard_media' }">
                            <i class="bi bi-list-ul"></i>  Media
                            </router-link>
                        </li>
                        <li class="nav-item d-flex">
                            <router-link :class="{ 'active': isActive(['dashboard_media_create']) , 'nav-link' : !isActive(['dashboard_media_create']) }" class="menu-media-create" @click="ajouterMedia" :to="{ name: 'dashboard_media_create' , params: { method :'create' } }">
                            <i class="bi bi-plus-lg"></i>  Ajouter media
                            </router-link>
                        </li>
                    </ul>
                </div>
            </li>
            <li v-if="this.user && this.user.role == 'admin'">
                <router-link :class="{ 'active': isActive(['dashboard_commentaire','dashboard_commentaire_create','dashboard_commentaire_edit']) , 'nav-link' : !isActive(['dashboard_commentaire','dashboard_commentaire_create','dashboard_commentaire_edit']) }" class=" menu-commentaire" :to="{ name: 'dashboard_commentaire'}">
                <i class="bi bi-chat-dots"></i>  Commentaires
                </router-link>
            </li>
            <li v-if="this.user && this.user.role == 'admin'">
                <router-link :class="{ 'active': isActive(['dashboard_page','dashboard_page_create','dashboard_page_edit']) , 'nav-link' : !isActive(['dashboard_page','dashboard_page_create','dashboard_page_edit']) }" class=" menu-page" :to="{ name: 'dashboard_page' }">
                <i class="bi bi-file-earmark"></i>  Page
                </router-link>
            </li>
            <li v-if="this.user && this.user.role == 'admin'">
                <a :class="{ 'active': isActive(['dashboard_user','dashboard_user_create','dashboard_user_edit']) , 'nav-link' : !isActive(['dashboard_user','dashboard_user_create','dashboard_user_edit']) }" class=" menu-user d-flex justify-content-between" href="#utilisateurMenu" data-bs-toggle="collapse">
                    <span><i class="bi bi-person"></i>  utilisateurs </span><i class="bi bi-caret-down"></i>
                </a> 
                <div class="collapse" id="utilisateurMenu">
                    <ul class="list-unstyled" style="margin-left: 15px;">
                        <li class="nav-item d-flex" >
                            <router-link :class="{ 'active': isActive(['dashboard_user']) , 'nav-link' : !isActive(['dashboard_user']) }" class=" menu-user-index" :to="{ name: 'dashboard_user'}">
                            <i class="bi bi-list-ul"></i>  Utilisateurs
                            </router-link>
                        </li>
                        <li class="nav-item d-flex">
                            <router-link :class="{ 'active': isActive(['dashboard_user_create']) , 'nav-link' : !isActive(['dashboard_user_create']) }" class="menu-user-create" @click="ajouterUser" :to="{ name: 'dashboard_user_create' , params: { method :'create' } }">
                            <i class="bi bi-plus-lg"></i>  Ajouter utilisateur
                            </router-link>
                        </li>
                                   
                    </ul>
                </div>
            </li>
        </ol>   
 


</template>

<script>
//import DashboardAppArticle from './DashboardAppArticle'
//import $ from 'jquery'
import axios from 'axios'

export default {
  name: 'DashboardApp',
  components: {
    //DashboardAppArticle,

  },
  props: {
    msg: String
  },
 emits :['createArticle','createCategorie','createUser','createMedia'],
  data(){
    return{
      interne:'nouveau test',
      routeName:null,
      user:{},
      addArticle : null,
      addCategorie : null,
      addMedia : null,
      addUser :null,
      accessToken : null,
      apiUrl: process.env.VUE_APP_API_URL

      
    }
  },
  methods:{
    ajouterArticle(){
    this.$emit('createArticle',this.addArticle = 1);
    },
    ajouterCategorie(){
    this.$emit('CreateCategorie',this.addCategorie = 1);
    },
    ajouterUser(){
    this.$emit('createUser',this.addUser = 1);
    },
    ajouterMedia(){
    this.$emit('createMedia',this.addMedia = 1);
    },

    fetchUser() {
      axios.defaults.headers.common['Authorization'] = `Bearer ${this.accessToken}`;
      axios.get(`${this.apiUrl}/api/user/connected`) // Appel de la route API pour récupérer l'utilisateur
        .then(response => {
          this.user = response.data; // Mettez à jour la propriété user avec les informations de l'utilisateur
            console.log(this.user)
        })
        .catch(error => {
          console.error(error);
        });
    },
    isActive(page){
      if(page && page.includes(this.routeName)){
        return true;
      }
    }
  },
  mounted() {
    const token = localStorage.getItem('access_token');
    this.accessToken = token;
    this.fetchUser();
  },
  watch: {
    '$route.name': {
      immediate: true, // Pour que le watcher se déclenche immédiatement après la création du composant
      handler(newParams) {
        this.routeName= newParams;
       

      }
    }
  }

}
</script>
