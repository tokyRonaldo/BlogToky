<template>
 <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid col-8">
    <div class="navbar-header">
      <H2 class="navbar-brand" >Monblog</H2>
       <button class="navbar-toggler" type="button" @click="toggleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

    <div class="nav navbar-nav navbar-right">
       <div class="collapse navbar-collapse" :class="{ 'show': isNavbarVisible }"  id="navbarSupportedContent">
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <router-link  :class="{ 'active': isActive(['app_home']) }" class="nav-link"  :to="{ name: 'app_home' }">
              Accueil
              </router-link>
            </li>
            <li class="nav-item dropdown">
              <a :class="{ 'active': isActive(['article_categorie']) }" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Categories
              </a>
              <ul v-if="this.categories" class="dropdown-menu">
                <li v-for='categorie in categories' :key="categorie.id">
                <a href="" class="text-decoration-none dropdown-item" @click="this.categorieLink(categorie.id)"  >
                  {{categorie.nom}}
                </a>
                </li>
                
              </ul>
            </li>
            <li class="nav-item">
               <router-link  :class="{ 'active': isActive(['article']) }" class="nav-link" :to="{ name: 'article' }">
                Pages
              </router-link>
            </li>
            <li v-if='!this.isAuth' class="nav-item">
            <router-link  :class="{ 'active': isActive(['app_register']) }" class="nav-link" :to="{ name: 'app_register' }">
                Inscription
              </router-link>
            </li>
            <li v-if='!this.isAuth' class="nav-item">
            <router-link  :class="{ 'active': isActive(['app_login'])}" class="nav-link" :to="{ name: 'app_login' }">
                Connexion
              </router-link>
            </li>
            <li class="nav-item dropdown" v-if='this.isAuth'>
              <a :class="{ 'active': isActive(['app_my_compte'])  }" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                User
              </a>
              <ul class="dropdown-menu">
                <li v-if='this.isAuth'><a @click="myCompte" :class="{ 'active': isActive(['app_my_compte']) }" class="nav-link dropdown-item" href="">Mon compte</a></li>
                <li v-if='this.isAuth'><a @click="logout" class="nav-link dropdown-item" href="">Deconnection</a></li>
                
              </ul>
            </li>
              <li v-if="this.isAuth && this.user && this.user.role == 'admin'" class="nav-item">
            <router-link  :class="{ 'active': isActive(['dashboard_article']) }" class="nav-link" :to="{ name: 'dashboard_article' }">
                Dashboard
              </router-link>
            </li>
        
          </ul>
        </div>
    </div>
  </div>
</nav>

</template>

<script>
import axios from 'axios';
export default {
  name: 'NavbarApp',
  props: {
    msg: String
  },
 
  data(){
    return{
      interne:'nouveau test',
      categories : {},
      isAuth :false,
      user:{},
      routeName: null,
       isNavbarVisible: false,
       apiUrl: process.env.VUE_APP_API_URL
    }
  },
  methods:{
    fetchCategories(){
      axios.get(`${this.apiUrl}/api/accueil/categorie`).then((response) => {
            this.categories = response.data;
            console.log(response.data);
        });
    },
    myCompte(){
      if(this.user){
            //redirection vers une autre route
            this.$router.push({ name: 'app_my_compte', params: {id : this.user.id} });
      }
    },          
    
    logout(){
      localStorage.removeItem('access_token');
      this.$router.push({ name: 'app_login' });
    },
    checkAuth(){
      const token = localStorage.getItem('access_token');
      if(token){
        this.isAuth = true;
      }
    },
    fetchUser() {
      const token = localStorage.getItem('access_token');
      if(token){
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      axios.get(`${this.apiUrl}/api/user/connected`) // Appel de la route API pour récupérer l'utilisateur
        .then(response => {
          this.user = response.data; // Mettez à jour la propriété user avec les informations de l'utilisateur
            console.log(this.user)
        })
        .catch(error => {
          console.error(error);
        });
      }
    },
    isActive(page){
      if(page && page.includes(this.routeName)){
        return true;
      }
    },
    categorieLink(id){
      //redirection vers une autre route
      this.$router.push({ name: 'article_categorie', params: { id: id} });
    },
    toggleNavbar() {
      this.isNavbarVisible = !this.isNavbarVisible;
    }
  },
  mounted() {
   this.fetchCategories();
   this.checkAuth();
   this.fetchUser();
   console.log(this.apiUrl)
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
