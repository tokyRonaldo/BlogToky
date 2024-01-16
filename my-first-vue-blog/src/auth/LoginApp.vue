<template>
<div class="container col-8">
  <div class="row mb-3">
    <h3>Login </H3>
    
  </div>
  <div v-if="showError" class="error mb-2">Le mot de pass ou nom d'utilisateur erroné.</div>
   <form @submit="loginForm" class="mb-3">
  <div class="row mb-2">
  <div class="form-group col-md-6">
    <label for="name"><b>Username:</b></label>
    <input type="text" required name="name" class="form-control" :class="{ 'error': showError }" id="username" v-model="formData.name">
  </div>
  </div>
  <div class="row ">
   <div class="form-group col-md-6">
    <label for="password"><b>Password:</b></label>
    <input type="password" required name="password" :class="{ 'error': showError }" class="form-control" id="password" v-model="formData.password">
  </div>
  
  </div>
   

  <br/>
  <button type="submit" id="btnAddUser"  class="btn btn-primary ">Submit</button>
  </form>
  <p>vous n'avez pas encore de compte? 
  <router-link class="text-decoration-none" :to="{ name: 'app_register'  }">
            s'inscrire
  </router-link>
  </p>
 
</div>


</template>

<script>
import axios from "axios";
export default {
  name: 'LoginApp',
    props: {
    data : Object
  },
 
  data(){
    return{
      interne:'nouveau test',
         formData: {
        name: '',
        password: '',
        role: '',
      },
      showError:false,
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
  methods:{
    async loginForm() {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddUser');
      submitBtn.disabled = true;
        await axios.post(`${this.apiUrl}/api/login`, this.formData).then((response) => {
            console.log(response);
              // Stockez le token d'accès dans le localStorage ou un cookie
              localStorage.setItem('access_token', response.data.token);

              // Redirigez l'utilisateur vers la page d'accueil ou une autre page après l'inscription
              this.$router.push('/');
        })
         .catch(error => {
            // Erreur de la requête
              this.formData.password = '';            
              this.showError = true;
              submitBtn.disabled = false;
            //this.showErrorAlert(error);
            console.error('Erreur de la requête :', error);
          });
    }
  },
   

}
</script>
<style scoped>
.error {
  border-color: red;
  color: red;
}
</style>