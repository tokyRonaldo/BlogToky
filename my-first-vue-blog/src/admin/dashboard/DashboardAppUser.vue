<template>
<div class="pt-1" >
  <div class="row">
    <div class="col-md-2  p-4 pt-0 border-right" style=" border-right: 1px solid #c2c2d6;">
    <DashboardApp @createUser="addUser" />
    </div>
    <div class="col-md-10">

        <IndexUserApp @editUser="modifierUser" @deleteUser="delUser" @createUser="addUser" v-if="statusIndexUser == 1"/>
        <CreateUserApp @emitSubmitUser="submitUser"  v-if="statusAddUser == 1" :data="dataAddUser"/>
        <EditUserApp @emitEditSubmitUser="editSubmitUser" v-if="statusEditUser == 1" :data="dataEditUser"/>
        <AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />
     
    </div>
    
  </div>
</div>


</template>

<script>
import axios from "axios";
import IndexUserApp from '../user/IndexUserApp.vue'
import CreateUserApp from '../user/CreateUserApp.vue'
import EditUserApp from '../user/EditUserApp.vue'
import AlertApp from '../../AlertApp.vue';
import DashboardApp from './DashboardApp.vue'

export default {
  name: 'DashboardAppUser',
  components: {
    IndexUserApp,
    CreateUserApp,
    EditUserApp,
    DashboardApp,
    AlertApp,
  },
  props: {
    msg: String
  },
 
  data(){
    return{
      interne:'nouveau test',
      test:'nouveau test',
      statusIndexUser:1,
      statusAddUser:null,
      statusEditUser:null,
      dataAddUser:{},
      dataEditUser:{},
      alert: {
        show: false,
        message: "",
        type: "success"
      },
      accessToken:null,
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
    addUser(message){
      axios.get("${this.apiUrl}/api/user/create").then((response) => {
      
      this.dataAddUser = response.data;
      this.statusAddUser = message;
      this.statusIndexUser = 0;
      this.statusEditUser = 0;
      console.log(this.dataAddUser);
    });
    },
    modifierUser(id){
 
      axios.get(`${this.apiUrl}/api/user/edit/${id}`).then((response) => {
        this.dataEditUser = response.data;
        this.statusAddUser = 0;
        this.statusIndexUser = 0;
        this.statusEditUser = 1;
        console.log(response.data);
    });
    },
    delUser(id){        
        axios.get(`${this.apiUrl}/api/user/destroy/${id}`).then((response) => {
            this.statusIndexUser = 0;
            this.statusEditUser = 0;
            this.statusAddUser = 0;
            this.statusIndexUser = 1;
      
            //redirection vers une autre route
            this.$router.go(0);
            
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
            this.$router.push({ name: 'dashboard_user' });
            
            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

          
    },
    submitUser(data){
      if(this.accessToken){
          axios.defaults.headers.common['Authorization'] = `Bearer ${this.accessToken}`;
      
          axios.post(`${this.apiUrl}/api/user/store`,data).then((response) => {         
            this.statusIndexUser = 0;
            this.statusEditUser = 0;
            this.statusAddUser = 0;
            this.statusIndexUser = 1;
            
            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_user' });
            
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
            this.$router.push({ name: 'dashboard_user' });

            this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });

      }else{
          this.$router.push('/login');
      }
    },
      editSubmitUser(data,id){
          axios.post(`${this.apiUrl}/api/user/update/${id}`,data).then((response) => {
            this.statusIndexUser = 0;
            this.statusEditUser = 0;
            this.statusAddUser = 0;
            this.statusIndexUser = 1;
            console.log(response.data);

            //redirection vers une autre route
            this.$router.push({ name: 'dashboard_user' });
            
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
            this.$router.push({ name: 'dashboard_user' });

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
    const token = localStorage.getItem('access_token');
    this.accessToken = token;
  },
   watch: {
    '$route.params': {
      immediate: true, // Pour que le watcher se déclenche immédiatement après la création du composant
      handler(newParams) {
        const method = newParams.method;
        this.routeMethod=method;

        if(this.routeMethod == 'create'){
            this.addUser(1);
        }
        else if(this.routeMethod == 'edit'){
            const id=newParams.id;
            this.modifierUser(id);
        }
        else{
          //this.$router.push({ name: 'dashboard_user' });
            this.statusEditUser = 0;
            this.statusIndexUser = 1;
            this.statusAddUser = 0;
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