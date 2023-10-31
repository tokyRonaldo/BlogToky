<template>
<div class="pt-1" >
  <div class="row">
    <div class="col-md-2  p-4 pt-0 border-right" style=" border-right: 1px solid #c2c2d6;">
    <DashboardApp @createCategorie="addCategorie"/>
    </div>
    <div class="col-md-10">

        <IndexCategorieApp @editCategorie="modifierCategorie" @deleteCategorie="delCategorie" @createCategorie="addCategorie" v-if="statusIndexCategorie == 1"/>
        <CreateCategorieApp @emitSubmitCategorie="submitCategorie"  v-if="statusAddCategorie == 1" :data="dataAddCategorie"/>
        <EditCategorieApp @emitEditSubmitCategorie="editSubmitCategorie" v-if="statusEditCategorie == 1" :data="dataEditCategorie"/>
        <AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />
     
    </div>
    
  </div>
</div>


</template>

<script>
import axios from "axios";
import IndexCategorieApp from '../categorie/IndexCategorieApp.vue'
import CreateCategorieApp from '../categorie/CreateCategorieApp.vue'
import EditCategorieApp from '../categorie/EditCategorieApp.vue'
import AlertApp from '../../AlertApp.vue';
import DashboardApp from './DashboardApp.vue'

export default {
  name: 'DashboardAppCategorie',
  components: {
    IndexCategorieApp,
    CreateCategorieApp,
    EditCategorieApp,
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
      statusIndexCategorie:1,
      statusAddCategorie:null,
      statusEditCategorie:null,
      dataAddCategorie:{},
      dataEditCategorie:{},
      alert: {
        show: false,
        message: "",
        type: "success"
      },
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
    addCategorie(message){
        axios.get("${this.apiUrl}/api/categorie/create").then((response) => {
        this.dataAddCategorie = response.data;
        this.statusIndexCategorie = 0;
        this.statusEditCategorie = 0;
        this.statusAddCategorie = message;
        console.log(this.dataAddCategorie);
    });
    },
     modifierCategorie(id){
 
        axios.get(`${this.apiUrl}/api/categorie/edit/${id}`).then((response) => {
        this.dataEditCategorie = response.data;
        this.statusIndexCategorie = 0;
        this.statusEditCategorie = 1;
        this.statusAddCategorie = 0;
        console.log(response.data);
    });

    },
    delCategorie(id){
        axios.get(`${this.apiUrl}/api/categorie/destroy/${id}`).then((response) => {
            this.statusIndexCategorie = 0;
            this.statusEditCategorie = 0;
            this.statusAddCategorie = 0;
            this.statusIndexCategorie = 1;

            //redirection vers une autre route
            this.$router.go(0);

            //this.dataAddCategorie = response.data;
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
            this.$router.push({ name: 'dashboard_categorie' });

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

            
    },
    submitCategorie(data){
        console.log(data);
          axios.post(`${this.apiUrl}/api/categorie/store`,data).then((response) => {
            this.statusIndexCategorie = 0;
            this.statusEditCategorie = 0;
            this.statusAddCategorie = 0;
            this.statusIndexCategorie = 1;
      
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_categorie' });

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
            this.$router.push({ name: 'dashboard_categorie' });
          
            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

          
    },
       editSubmitCategorie(data,id){
          axios.post(`${this.apiUrl}/api/categorie/update/${id}`,data).then((response) => {
            this.statusIndexCategorie = 0;
            this.statusEditCategorie = 0;
            this.statusAddCategorie = 0;
            this.statusIndexCategorie = 1;
      
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_categorie' });

            //this.dataAddCategorie = response.data;
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
            this.$router.push({ name: 'dashboard_categorie' });

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
            this.addCategorie(1);
        }
        else if(this.routeMethod == 'edit'){
            const id=newParams.id;
            this.modifierCategorie(id);
        }
        else{
            this.statusEditCategorie = 0;
            this.statusIndexCategorie = 1;
            this.statusAddCategorie = 0;
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