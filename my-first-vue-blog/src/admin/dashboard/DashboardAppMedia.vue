<template>
<div class="pt-1" >
  <div class="row">
    <div class="col-md-2  p-4 pt-0 border-right" style=" border-right: 1px solid #c2c2d6;">
    <DashboardApp @createMedia="addMedia"/>
    </div>
    <div class="col-md-10">

        <IndexMediaApp @editMedia="modifierMedia" @deleteMedia="delMedia" @createMedia="addMedia" v-if="statusIndexMedia == 1"/>
        <CreateMediaApp @emitSubmitMedia="submitMedia"  v-if="statusAddMedia == 1" :data="dataAddMedia"/>
        <EditMediaApp @emitEditSubmitMedia="editSubmitMedia" v-if="statusEditMedia == 1" :data="dataEditMedia"/>
        <AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />
     
    </div>
    
  </div>
</div>


</template>

<script>
import axios from "axios";
import IndexMediaApp from '../media/IndexMediaApp.vue'
import CreateMediaApp from '../media/CreateMediaApp.vue'
import EditMediaApp from '../media/EditMediaApp.vue'
import AlertApp from '../../AlertApp.vue';
import DashboardApp from './DashboardApp.vue'

export default {
  name: 'DashboardAppMedia',
  components: {
    IndexMediaApp,
    CreateMediaApp,
    EditMediaApp,
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
      statusIndexMedia:1,
      statusAddMedia:null,
      statusEditMedia:null,
      dataAddMedia:{},
      dataEditMedia:{},
      alert: {
        show: false,
        message: "",
        type: "success"
      },
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
    addMedia(message){

        axios.get(`${this.apiUrl}/api/media/create`).then((response) => {
        this.statusIndexMedia = 0;
        this.statusEditMedia = 0;
        this.statusAddMedia = message;
      
        this.dataAddMedia = response.data;
        console.log(this.dataAddMedia);
      });
    },
     modifierMedia(id){
        axios.get(`${this.apiUrl}/api/media/edit/${id}`).then((response) => {
            this.dataEditMedia = response.data;
            this.statusIndexMedia = 0;
            this.statusEditMedia = 1;
            this.statusAddMedia = 0;
            console.log(response.data);
      });
    },
    delMedia(id){
        axios.get(`${this.apiUrl}/api/media/destroy/${id}`).then((response) => {
            this.statusIndexMedia = 0;
            this.statusEditMedia = 0;
            this.statusAddMedia = 0;
            this.statusIndexMedia = 1;
      
            //redirection vers une autre route
            this.$router.go(0);

            //this.dataAddMedia = response.data;
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
            this.$router.push({ name: 'dashboard_media' });

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

          
    },
    submitMedia(data){
        axios.post(`${this.apiUrl}/api/media/store`,data,{headers: {
          'Content-Type': 'multipart/form-data',
        }
        }).then((response) => {
            this.statusIndexMedia = 0;
            this.statusEditMedia = 0;
            this.statusAddMedia = 0;
            this.statusIndexMedia = 1;
      
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_media' });

            //this.dataAddMedia = response.data;
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
            this.$router.push({ name: 'dashboard_media' });

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

          
    },
       editSubmitMedia(data,id){
        console.log(data);
          axios.post(`${this.apiUrl}/api/media/update/${id}`,data,{headers: {
          'Content-Type': 'multipart/form-data',
        }
        }).then((response) => {
            this.statusIndexMedia = 0;
            this.statusEditMedia = 0;
            this.statusAddMedia = 0;
            this.statusIndexMedia = 1;
      
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_media' });

            //this.dataAddMedia = response.data;
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
            this.$router.push({ name: 'dashboard_media' });
           
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
            this.addMedia(1);
        }
        else if(this.routeMethod == 'edit'){
            const id=newParams.id;
            this.modifierMedia(id);
        }
        else{
            this.statusEditMedia = 0;
            this.statusIndexMedia = 1;
            this.statusAddMedia = 0;
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