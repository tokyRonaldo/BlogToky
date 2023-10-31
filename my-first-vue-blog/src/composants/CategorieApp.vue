<template>
<div class="container col-8">
  <div class="row">
    <div class="col-md-12">
      <H4 class="fst-italic border-bottom p-4">Titre du categorie</H4>
      <div class="row " v-for="articleCategorie in formData" :key="articleCategorie.id">
        <div class="col-md-5">
          <router-link v-if='articleCategorie.media && articleCategorie.media.length > 0' :to="{ name: 'article_show' , params: { id : articleCategorie.id } }">
            <img v-if="articleCategorie.media[0].src" class="img-responsive col-md-12" :src="'http://127.0.0.1:8000/storage/images/'+articleCategorie.media[0].src"  >
          </router-link>
        </div>
        <div class="col-md-7">
          <h4>
          <router-link class="text-decoration-none" :to="{ name: 'article_show' , params: { id : articleCategorie.id } }">
            {{articleCategorie.titre}}
          </router-link>
          </h4>
          <p>
          {{this.formattedDate(articleCategorie.created_at)}}
          </p>
          <p>
          {{this.sliceContenu(articleCategorie.contenu,30)}}
          </p>
          
        </div>
      </div>
      <ul class="pagination">
            <li v-if="pagination.prev_page_url">
                <a @click="fetchAllCategories(routeId,pagination.current_page - 1)" href="#">Précédent<span v-if="pagination.next_page_url"> / </span></a>
            </li>
            <li v-if="pagination.next_page_url">
                <a @click="fetchAllCategories(routeId,pagination.current_page + 1)" href="#">Suivant</a>
            </li>
        </ul>    
    </div>
  </div>
</div>


</template>

<script>
import axios from 'axios';
import moment from 'moment';
export default {
  name: 'CategorieApp',
  props: {
    msg: Object
  },
 
  data(){
    return{
      interne:'nouveau test',
      routeId:null,
      formData:[],
      pagination :{},
      apiUrl: process.env.VUE_APP_API_URL
    }
  },
  methods:{
     fetchAllCategories(id,page=1){
            axios.get(`${this.apiUrl}/api/categorie/${id}?page=${page}`).then((response) => {
              this.formData = response.data;
              this.pagination = response.data.reponses;
              console.log(response);
            });
          },
            showArticle(id){
            console.log(id)
            //utilisant la route
          },
        formattedDate(date) {
          // Utilisez moment pour formater la date
          console.log(date);
          return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
         sliceContenu(contenu,nbre){
          if(contenu){
          return contenu.slice(0,nbre);
          }
        }
  },
  mounted() {
        //this.fetchAllCategories();
        const id = this.$route.params.id; 
        this.routeId= id;
        this.fetchAllCategories(id,1);
        console.log(id);

  },
    //watch: {
    //'$route.params': {
      //immediate: true, // Pour que le watcher se déclenche immédiatement après la création du composant
      //handler(newParams) {
        //const id = newParams.id;
        //this.routeId= id;
        //this.fetchAllCategories(id,1);
      //}
    //}
  //}

}
</script>
