<template>
<div class="container col-8">
  <div class="row" >
    <div class="col-md-12">
      <H4 class="fst-italic border-bottom p-4">Articles</H4>
      <div class="row " v-for="allArticle in formData" :key="allArticle.id">
        <div class="col-md-5">
           <router-link v-if='allArticle.media && allArticle.media.length > 0' :to="{ name: 'article_show' , params: { id : allArticle.id } }">
            <img  v-if="allArticle.media[0].src" class="img-responsive col-md-12" :src="'http://127.0.0.1:8000/storage/images/'+allArticle.media[0].src">
          </router-link>
        </div>
        <div class="col-md-7">
          <h4 v-if="allArticle">
            <router-link v-if="allArticle.id" class="text-decoration-none" :to="{ name: 'article_show' , params: { id : allArticle.id } }">
              {{allArticle.titre}}
            </router-link>
          
          </h4>
          <p>
          {{this.formattedDate(allArticle.created_at)}}
          </p>
          <p>
          {{this.sliceContenu(allArticle.contenu,30)}}
          </p>
          
        </div>
      </div>    
       <ul class="pagination">
            <li v-if="pagination.prev_page_url">
                <a @click="fetchAllArticles(pagination.current_page - 1)" href="#">Précédent<span v-if="pagination.next_page_url"> / </span></a>
            </li>
            <li v-if="pagination.next_page_url">
                <a @click="fetchAllArticles(pagination.current_page + 1)" href="#">Suivant</a>
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
  name: 'ArticleApp',
  props: {
    msg: String
  },
 
  data(){
    return{
      interne:'nouveau test',
      formData : [],
      pagination : {},
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
          fetchAllArticles(page = 1){
            axios.get(`${this.apiUrl}/api/allArticle?page=${page}`).then((response) => {
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
        console.log('hello');
        this.fetchAllArticles(1);

      },

}
</script>
