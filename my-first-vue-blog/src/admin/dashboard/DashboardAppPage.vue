<template>
<div class="pt-1" >
  <div class="row">
    <div class="col-md-2  p-4 pt-0 border-right" style=" border-right: 1px solid #c2c2d6;">
    <DashboardApp />
    </div>
    <div class="col-md-10">

        <IndexPageApp @editPage="modifierPage" @deletePage="delPage" @createPage="addPage" v-if="statusIndexPage == 1"/>
        <CreatePageApp @emitSubmitPage="submitPage"  v-if="statusAddPage == 1" :data="dataAddPage"/>
        <EditPageApp @emitEditSubmitPage="editSubmitPage" v-if="statusEditPage == 1" :data="dataEditPage"/>
        <AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />
     
    </div>
    
  </div>
</div>


</template>

<script>
import axios from "axios";
import IndexPageApp from '../page/IndexPageApp.vue'
import CreatePageApp from '../page/CreatePageApp.vue'
import EditPageApp from '../page/EditPageApp.vue'
import AlertApp from '../../AlertApp.vue';
import DashboardApp from './DashboardApp.vue'

export default {
  name: 'DashboardAppPage',
  components: {
    IndexPageApp,
    CreatePageApp,
    EditPageApp,
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
      statusIndexPage:1,
      statusAddPage:null,
      statusEditPage:null,
      dataAddPage:{},
      dataEditPage:{},
      alert: {
        show: false,
        message: "",
        type: "success"
      },
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
    addPage(message){

        axios.get(`${this.apiUrl}/api/page/create`).then((response) => {
      
          this.dataAddPage = response.data;
          this.statusIndexPage = 0;
          this.statusEditPage = 0;
          this.statusAddPage = message;
          console.log(this.dataAddPage);
        })
         .catch(error => {
            // Erreur de la requête

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });
    },
     modifierPage(id){
        axios.get(`${this.apiUrl}/api/page/edit/${id}`).then((response) => {
              this.dataEditPage = response.data;
              this.statusIndexPage = 0;
              this.statusEditPage = 1;
              this.statusAddPage = 0;
              console.log(response.data);
        })
         .catch(error => {
            // Erreur de la requête

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });
    },
    delPage(id){       
        axios.get(`${this.apiUrl}/api/page/destroy/${id}`).then((response) => {
            this.statusIndexPage = 0;
            this.statusEditPage = 0;
            this.statusAddPage = 0;
            this.statusIndexPage = 1;
      
            //redirection vers une autre route
            this.$router.go(0);

            //this.dataAddPage = response.data;
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
            this.$router.push({ name: 'dashboard_page' });

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

          
    },
    submitPage(data){
        axios.post(`${this.apiUrl}/api/page/store`,data,{headers: {
          'Content-Type': 'multipart/form-data',
        }
        }).then((response) => {
            this.statusIndexPage = 0;
            this.statusEditPage = 0;
            this.statusAddPage = 0;
            this.statusIndexPage = 1;
      
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_page' });

            //this.dataAddPage = response.data;
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
            this.$router.push({ name: 'dashboard_page' });

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

          
    },
       editSubmitPage(data,id){
          axios.post(`${this.apiUrl}/api/page/update/${id}`,data,{headers: {
          'Content-Type': 'multipart/form-data',
           }
            }).then((response) => {
            this.statusIndexPage = 0;
            this.statusEditPage = 0;
            this.statusAddPage = 0;
            this.statusIndexPage = 1;
      
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_page' });

            //this.dataAddPage = response.data;
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
            this.$router.push({ name: 'dashboard_page' });

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
            this.addPage(1);
        }
        else if(this.routeMethod == 'edit'){
            const id=newParams.id;
            this.modifierPage(id);
        }
         else{
            this.statusEditPage = 0;
            this.statusIndexPage = 1;
            this.statusAddPage = 0;
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