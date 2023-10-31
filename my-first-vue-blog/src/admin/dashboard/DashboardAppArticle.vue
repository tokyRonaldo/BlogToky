<template>
<div class="pt-1" >
  <div class="row">
    <div class="col-md-2  p-4 pt-0 border-right" style=" border-right: 1px solid #c2c2d6;">
    <DashboardApp  @createArticle="addArticle" />
    </div>
    <div class="col-md-10">

        <IndexArticleApp @editArticle="modifierArticle" @deleteArticle="delArticle" @createArticle="addArticle" v-if="statusIndexArticle == 1"/>
        <CreateArticleApp @emitSubmitArticle="submitArticle"  v-if="statusAddArticle == 1" :data="dataAddArticle"/>
        <EditArticleApp @emitEditSubmitArticle="editSubmitArticle" v-if="statusEditArticle == 1" :data="dataEditArticle"/>
        <AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />
     
    </div>
    
  </div>
</div>


</template>

<script>
import axios from "axios";
import IndexArticleApp from '../article/IndexArticleApp.vue'
import CreateArticleApp from '../article/CreateArticleApp.vue'
import EditArticleApp from '../article/EditArticleApp.vue'
import AlertApp from '../../AlertApp.vue';
import DashboardApp from './DashboardApp.vue'

export default {
  name: 'DashboardAppArticle',
  components: {
    IndexArticleApp,
    CreateArticleApp,
    EditArticleApp,
    DashboardApp,
    AlertApp
  },
  props: {
    msg: String
  },
 
  data(){
    return{
      interne:'nouveau test',
      test:'nouveau test',
      statusIndexArticle:1,
      statusAddArticle:null,
      statusEditArticle:null,
      dataAddArticle:{},
      dataEditArticle:{},
      routeMethod:null,
      alert: {
        show: false,
        message: "",
        type: "success"
      },
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
    addArticle(message){
        axios.get("${this.apiUrl}/api/article/create").then((response) => {
          this.dataAddArticle = response.data;
          this.statusIndexArticle = 0;
          this.statusAddArticle = message;
          this.statusEditArticle = 0;
          console.log(this.dataAddArticle);
    });
    },
     modifierArticle(id){
        
        axios.get(`${this.apiUrl}/api/article/edit/${id}`).then((response) => {
          this.dataEditArticle = response.data;
          this.statusIndexArticle = 0;
          this.statusEditArticle = 1;
          this.statusAddArticle = 0;
          this.statusAddArticle = 0;
          console.log(response.data.article.titre);
        });

        //const self = this;
        //await $.post("${this.apiUrl}/api/article/edit", 
        //                {
        //                    id: id
        //                }, function (data) {
        //                    console.log(data);
        //                    self.dataEditArticle = data;
        //                    self.statusEditArticle = 1;
        //                    console.log(self.statusEditArticle )
        //                });
        //                console.log(this.statusEditArticle )
    },
    delArticle(id){
        axios.get(`${this.apiUrl}/api/article/destroy/${id}`).then((response) => {
            this.statusEditArticle = 0;
            this.statusAddArticle = 0;
            this.statusIndexArticle = 0;
            this.statusIndexArticle = 1;

            //redirection vers une autre route
            //this.$router.push({ name: 'dashboard_article' });
            this.$router.go(0);

            if(response.data.success == 1){
              this.showSuccessAlert(response.data.msg);
            }
            else{
            this.showErrorAlert(response.data.msg);
            }
        })
        .catch(error => {
            // Erreur de la requête

            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_article' });

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

          
    },
    submitArticle(data){
        console.log(data);
          axios.post(`${this.apiUrl}/api/article/store`,data).then((response) => {
            this.statusEditArticle = 0;
            this.statusAddArticle = 0;
            //this.statusIndexArticle = 0;
            //this.statusIndexArticle = 1;
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_article' });
            
            //this.$router.go(0);
            if(response.data.success == 1){
              this.showSuccessAlert(response.data.msg);
            }
            else{
            this.showErrorAlert(response.data.msg);
            }
        })
        .catch(error => {
            // Erreur de la requête
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_article' });
            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });
            
          
    },
       editSubmitArticle(data,id){
        console.log(data);
          axios.post(`${this.apiUrl}/api/article/update/${id}`,data).then((response) => {
            this.statusIndexArticle = 0;
            this.statusEditArticle = 0;
            this.statusIndexArticle = 1;
            this.statusAddArticle = 0;
            
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_article' });
            if(response.data.success == 1){
              this.showSuccessAlert(response.data.msg);
            }
            else{
            this.showErrorAlert(response.data.msg);
            }
        })
        .catch(error => {
            // Erreur de la requête

            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_article' });

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
    }
  },
  mounted(){
     
  },
  //au cas ou j'en ai besoin
   watch: {
    '$route.params': {
      immediate: true, // Pour que le watcher se déclenche immédiatement après la création du composant
      handler(newParams, oldParams) {
        const method = newParams.method;
        console.log(oldParams);
        console.log(method);
        this.routeMethod=method;

        if(this.routeMethod == 'create'){
          this.addArticle(1);
        }
        else if(this.routeMethod == 'edit'){
          const id=newParams.id;
          this.modifierArticle(id);
        }
        else{
          this.statusEditArticle = 0;
            this.statusIndexArticle = 1;
            this.statusAddArticle = 0;
        }
      }
    }
  }

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