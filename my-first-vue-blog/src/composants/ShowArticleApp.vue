<template>
<div class="container col-8">
  <div class="row">
    <div class="col-md-12">
      
          <h3>
            <a class="text-decoration-none" href="">
              {{this.formData.article.titre}}
            </a>
          </h3>
          <div v-if='formData.media && formData.media.length > 0'>
          <img class="img-responsive col-md-10" v-if="formData.media[0].src" :src="'http://127.0.0.1:8000/storage/images/'+formData.media[0].src"  >
          </div >
          <br/>
          <p>
          {{this.formattedDate(this.formData.article.created_at)}}
          </p>
          <p>
          {{this.sliceContenu(this.formData.article.contenu,30)}}
          </p> 

          <div class="commentaire">
          <H4>
           <span id='nmbreCommentaire'>{{this.formData.commentaires.length}} commentaire(s)</span>
          </H4>
          <Hr/>
         
          <div class="ajouter-commentaire">
          <form @submit="addNewComment">
            <div class="form-group ">
              <label for="role"><b>votre message:</b></label>
              <textarea class="form-control" name="newComment" id="new_comment" v-model="newComment"></textarea>
            </div>
            <br/>
          <button type="submit" id="btnAddNewComment"  class="btn btn-primary">Envoyer</button>
          </form>
          </div>
          <br/>
           <div class="list-commentaire mb-2" v-for="allCommentaire in formData.commentaires" :key="allCommentaire.id">
          <span id="commentUser" >
          <b>
          <span v-if="!allCommentaire.user">Utilisateur inconnue</span>
          {{allCommentaire.user}}
          </b>
          </span>
          <span id="commentCreatedAt">
          ( {{this.formattedDate(allCommentaire.created_at)}} )
        

          </span>
          <p> {{allCommentaire.contenu}}</p> 
          </div>
          <ul class="pagination" v-if="pagination">
            <li v-if="pagination.prev_page_url">
                <a @click="fetchShowArticle(routeId,pagination.current_page - 1)" href="#">Précédent<span v-if="pagination.next_page_url"> / </span></a>
            </li>
            <li v-if="pagination.next_page_url">
                <a @click="fetchShowArticle(routeId,pagination.current_page + 1)" href="#">Suivant</a>
            </li>
        </ul>    
          <Hr/>

          </div>
      
    </div>
    
  </div>
</div>
<AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />


</template>

<script>
import axios from 'axios';
import moment from 'moment';
import AlertApp from '../AlertApp.vue';

export default {
  name: 'ShowArticleApp',
    components: {
    AlertApp,
  },
  props: {
    msg: Object
  },
 
  data(){
    return{
      interne:'nouveau test',
      formData:{
        article :Object,
        article_categories :Object,
        commentaires :Object,
        user:Object,
        media:[]
      },
      routeId : null,
      pagination :{},
      newComment:null,
      alert: {
        show: false,
        message: "",
        type: "success"
      },
      imagePath: '/storage/images/image.jpg',
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
          fetchShowArticle(id,page=1){
            axios.get(`${this.apiUrl}/api/article/show/${id}?page=${page}`).then((response) => {
              //this.formData = response.data;
              console.log(response);
              this.formData.article = response.data.article;
              this.formData.media = response.data.media;
              this.formData.user = response.data.user;
              this.formData.article_categories = response.data.article_categories;
              this.formData.commentaires = response.data.commentaires;
              this.pagination = response.data.commentaires.reponses;
            });

          },
          addNewComment(event){
            event.preventDefault();           
            const data={
              commentaire: this.newComment,
              article_id: this.formData.article.id,
              //user_id: this.formData.user.id,
            };
            console.log(data)
            axios.post(`${this.apiUrl}/api/commentaire/store`,data).then((response) => {
              this.newComment = null;
              this.fetchShowArticle(this.formData.article.id,1)
              console.log(response.data);
              if(response.data.success == 1){
                this.showSuccessAlert(response.data.msg);
              }
              else{
                this.showErrorAlert(response.data.msg);
              }
            })
            .catch(error => {
              // Erreur de la requête
              this.showErrorAlert(error);
              console.error('Erreur de la requête :', error);
            });
          },
          showSuccessAlert(mess) {
          this.alert = {
            show: true,
            message: mess,
            type: "success"
          };
          console.log('showSuccessAlert');
          
          // Masquez l'alerte après 3 secondes
          setTimeout(() => {
          this.alert = {
            show: false,
            message: "",
            type: "success"
          };
          }, 5000);
        },
        showErrorAlert(mess) {
          this.alert = {
            show: true,
            message: mess,
            type: "danger"
          };

          // Masquez l'alerte après 3 secondes
          setTimeout(() => {
          this.alert = {
            show: false,
            message: "",
            type: "danger"
          };
          }, 5000);
        },
        formattedDate(date) {
          // Utilisez moment pour formater la date
          return moment(date).format('YYYY-MM-DD HH:mm:ss');
        },
         sliceContenu(contenu,nbre){
          if(contenu){
          return contenu.slice(0,nbre);
          }
        }
  },
  mounted() {
        const id = this.$route.params.id;
        this.routeId= id;
        this.fetchShowArticle(id,1);

      },

}
</script>
<style scoped>
.alertApp {
   top: 0;
    right: 0;
    width: 180px;
    margin-right:10px;
    margin-left:10px;
  position: fixed;
}


</style>