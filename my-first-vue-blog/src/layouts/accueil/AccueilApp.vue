<template>
<div class="container col-8">

  <div class="row">
    <div class="col-md-8">
      <H4 class="fst-italic border-bottom p-4">Articles récents</H4>
      <AccueilArticle :data="formData.article" />
    </div>
    <div class="col-md-4 ">
    <AccueilApropos :data="formData.apropos" />
    <AccueilCategorie :data="formData.categorie" />
    </div>
  </div>
</div>
<router-view></router-view>

</template>

<script>
import axios from "axios";
import AccueilApropos from './AccueilApropos.vue'
import AccueilCategorie from './AccueilCategorie.vue'
import AccueilArticle from './AccueilArticle.vue'

export default {
  name: 'AccueilApp',
  props: {
    msg: String
  },
  components: {
    AccueilApropos,
    AccueilArticle,
    AccueilCategorie,
  },
 
  data(){
    return{
      interne:'nouveau test',
      formData:{
        article:null,
        apropos:null,
        categorie:null
      },
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
    fetchArticles(){
      axios.get(`${this.apiUrl}/api/accueil/article`).then((response) => {
            this.formData.article = response.data;
            console.log(response.data);
        });

    },
    fetchApropos(){
      console.log('apropos');
      axios.get(`${this.apiUrl}/api/accueil/apropos`).then((response) => {
            this.formData.apropos = response.data;
            console.log(response.data);
        });

    },
    fetchCategories(){
      axios.get(`${this.apiUrl}/api/accueil/categorie`).then((response) => {
            this.formData.categorie = response.data;
            console.log(response.data);
        });

    }
  },
  mounted() {
   console.log('hello');
   this.fetchArticles();
   this.fetchCategories();
   this.fetchApropos();
   //console.log(localStorage.getItem('access_token'))
  },

}
</script>
