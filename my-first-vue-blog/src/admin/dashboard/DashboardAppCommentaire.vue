<template>
<div class="pt-1" >
  <div class="row">
    <div class="col-md-2  p-4 pt-0 border-right" style=" border-right: 1px solid #c2c2d6;">
    <DashboardApp />
    </div>
    <div class="col-md-10">

        <IndexCommentaireApp @editCommentaire="modifierCommentaire" @deleteCommentaire="delCommentaire" @createCommentaire="addCommentaire" v-if="statusIndexCommentaire == 1"/>
        <EditCommentaireApp @emitEditSubmitCommentaire="editSubmitCommentaire" v-if="statusEditCommentaire == 1" :data="dataEditCommentaire"/>
        <AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />
     
    </div>
    
  </div>
</div>


</template>

<script>
import axios from "axios";
import IndexCommentaireApp from '../commentaire/IndexCommentaireApp.vue'
//import CreateCommentaireApp from '../commentaire/CreateCommentaireApp.vue'
import EditCommentaireApp from '../commentaire/EditCommentaireApp.vue'
import AlertApp from '../../AlertApp.vue';
import DashboardApp from './DashboardApp.vue'

export default {
  name: 'DashboardAppCommentaire',
  components: {
    IndexCommentaireApp,
    //CreateCommentaireApp,
    EditCommentaireApp,
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
      statusIndexCommentaire:1,
      statusAddCommentaire:null,
      statusEditCommentaire:null,
      dataAddCommentaire:{},
      dataEditCommentaire:{},
      alert: {
        show: false,
        message: "",
        type: "success"
      },
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
    
     modifierCommentaire(id){
        axios.get(`${this.apiUrl}/api/commentaire/edit/${id}`).then((response) => {
            this.dataEditCommentaire = response.data;
            this.statusIndexCommentaire = 0;
            this.statusEditCommentaire = 1;
            this.statusAddCommentaire = 0;
        
         });

     },
    delCommentaire(id){
        axios.get(`${this.apiUrl}/api/commentaire/destroy/${id}`).then((response) => {
          this.statusIndexCommentaire = 0;
            this.statusEditCommentaire = 0;
            this.statusAddCommentaire = 0;
            this.statusIndexCommentaire = 1; 

            //redirection vers une autre route
            this.$router.go(0);

            //this.dataAddCommentaire = response.data;
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

            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_commentaire' });

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

          
    },
   
       editSubmitCommentaire(data,id){
        console.log(data);
          axios.post(`${this.apiUrl}/api/commentaire/update/${id}`,data).then((response) => {
            this.statusIndexCommentaire = 0;
            this.statusEditCommentaire = 0;
            this.statusAddCommentaire = 0;
            this.statusIndexCommentaire = 1;
      
            //this.dataAddCommentaire = response.data;
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

            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_commentaire' });

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
   watch: {
    '$route.params': {
      immediate: true, // Pour que le watcher se déclenche immédiatement après la création du composant
      handler(newParams, oldParams) {
        const method = newParams.method;
        console.log(oldParams);
        console.log(method);
        this.routeMethod=method;

        if(this.routeMethod == 'create'){
          this.addCommentaire(1);
        }
        else if(this.routeMethod == 'edit'){
            const id=newParams.id;
            this.modifierCommentaire(id);
        }
        else{
            this.statusEditCommentaire = 0;
            this.statusIndexCommentaire = 1;
            this.statusAddCommentaire = 0;
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