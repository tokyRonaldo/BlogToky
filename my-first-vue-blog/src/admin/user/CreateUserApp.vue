<template>
<div class="container">
  <div class="row mb-3">
<h3>Ajouter utilisateur </H3>
    
  </div>
   <form @submit="submitForm">
  <div class="row mb-2">
  <div class="form-group col-md-4">
    <label for="name"><b>Username:</b></label>
    <input type="text" required name="name" class="form-control" id="username" v-model="formData.name">
  </div>
   <div class="form-group col-md-4">
    <label for="password"><b>Password:</b></label>
    <input type="password" required name="password" class="form-control" id="password" v-model="formData.password">
  </div>
   <div class="form-group col-md-4">
    <label for="role"><b>Role:</b></label>
     <select name="role" required v-model="formData.role" class="form-control">
    <option value="" disabled selected >Selectionnez</option>
    <option :value="dataRole"  v-for="dataRole in dataRoles" :key="dataRole">{{dataRole}}</option>
    </select>
  </div>
  </div>
   

  <br/>
  <button type="submit" id="btnAddUser"  @click="submitUser" class="btn btn-primary float-end">Submit</button>
</form>
 
</div>


</template>

<script>
export default {
  name: 'CreateUserApp',
  props: {
  data : Object
  },
 emits :['emitSubmitUser'],
 
  data(){
    return{
      interne:'nouveau test',
         formData: {
        name: '',
        password: '',
        role: '',
      },
      dataRoles :['admin','user','writer']
      
    }
  },
  methods:{
      submitForm(event) {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddUser');
      submitBtn.disabled = true;

      console.log(this.formData);

      //redirection vers une autre route
      //this.$router.push({ name: 'dashboard_user_store' });

      // Effectuez ici toute logique nécessaire, par exemple, soumettez les données à un serveur via une requête AJAX.
      this.$emit('emitSubmitUser',this.formData);

    },
 
  },
   

}
</script>
