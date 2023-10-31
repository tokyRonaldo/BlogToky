<template>
<div class="container col-8">
  <div class="row mb-2">
  <h3>Register </H3>
    
  </div>
   <form @submit="registerForm" class="mb-3">
  <div class="row mb-2">
  <div class="form-group col-md-6">
    <label for="name"><b>Username:</b></label>
    <input type="text" required name="name" class="form-control" id="username" :class="{ 'error': showError }" v-model="formData.name">
    <div v-if="showError" class="error">Le nom d'utilisateur doit contenir au moins 6 caractères et unique.</div>
  </div>
  </div>
  <div class="row mb-2">
   <div class="form-group col-md-6">
    <label for="password"><b>Password:</b></label>
    <input type="password" required name="password" class="form-control" id="password" :class="{ 'error': showError }" v-model="formData.password">
    <div v-if="showError" class="error">Le mot de pass doit contenir au moins 6 caractères.</div>
    </div>
  </div>
  <div class="row">
   <div class="form-group col-md-6">
    <label for="email"><b>Email:</b></label>
    <input type="email" name="email" required class="form-control" id="email" v-model="formData.email">
  </div>
  </div>
   

  <br/>
  <button type="submit" id="btnAddUser"  @click="submitUser" class="btn btn-primary ">Submit</button>
  </form>
  <p>vous avez déja un compte? 
  <router-link class="text-decoration-none" :to="{ name: 'app_login'  }">
            se connecter
  </router-link>
  </p>
</div>

<AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />

</template>

<script>
import axios from "axios";
import AlertApp from '../AlertApp.vue';
export default {
  name: 'RegisterApp',
  props: {
  data : Object
  },
  components: {
    AlertApp,
  },
 
  data(){
    return{
      interne:'nouveau test',
         formData: {
        name: '',
        password: '',
        email: '',
        role: '',
        },
        alert: {
        show: false,
        message: "",
        type: "success"
        },
        showError: false,
        apiUrl: process.env.VUE_APP_API_URL
      
      }
  },
  methods:{
  async registerForm() {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddUser');
      submitBtn.disabled = true;
        await axios.post('${this.apiUrl}/api/register', this.formData).then((response) => {
            console.log(response);
            if(response.data.success == 1){
              // Stockez le token d'accès dans le localStorage ou un cookie
              localStorage.setItem('access_token', response.data.token);

              // Redirigez l'utilisateur vers la page d'accueil ou une autre page après l'inscription
              this.$router.push('/');
            }
            else{
              this.showError = true;
              submitBtn.disabled = false;
            }
        })
         .catch(error => {
            // Erreur de la requête
            
            this.showErrorAlert(error);
            submitBtn.disabled = false;
            //console.error('Erreur de la requête :', error);
          });
      
    } ,
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
.error {
  border-color: red; /* ou toute autre mise en forme pour indiquer l'erreur */
}
</style>