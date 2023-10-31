<template>
<div class="row " v-for="article in data" :key="article.id">
        <div class="col-md-5">
          <router-link v-if='article.media && article.media.length > 0' :to="{ name: 'article_show' , params: { id : article.id } }">
            <img v-if="article.media[0].src"  class="img-responsive col-md-12" :src="'http://127.0.0.1:8000/storage/images/'+article.media[0].src">
          </router-link>
        </div>
        <div class="col-md-7">
          <h4>
          <router-link  class="text-decoration-none" :to="{ name: 'article_show' , params: { id : article.id } }">
              {{article.titre}}
          </router-link>
          </h4>
          <p>
          {{this.formattedDate(article.created_at)}}
          </p>
          <p>
          {{this.sliceContenu(article.contenu,30)}}
          </p>
          
        </div>
      </div>

</template>

<script>
import moment from 'moment';
export default {
  name: 'AccueilArticle',
  props: {
    data: Object
  },
 
  data(){
    return{
      interne:'nouveau test',
      
    }
  },
  methods:{
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
  }

}
</script>
