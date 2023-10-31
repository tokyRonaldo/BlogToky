<template>
<div class="container">
  <div class="row mb-3">
<h3>Editer page </H3>
    
  </div>
  <form @submit="editSubmitForm">
  <div class="row mb-2">
  <div class="form-group col-md-4">
    <label for="titre"><b>Titre:</b></label>
    <input type="text" required name="titre" class="form-control" id="titre" v-model="formData.titre">
  </div>
  <div class="form-group col-md-4">
    <label for="apropos"><b>Apropos:</b></label>
    <select name="apropos" required v-model="formData.apropos" class="form-control">
    <option value="" disabled>Selectionnez</option>
    <option :value="user.id"  v-for="user in data.allUser" :key="user.id">{{user.name}}</option>
     </select>
  </div>
  <div class="form-group col-md-4">
    <label for="nbreArticle"><b>Nbre d'article:</b></label>
    <input type="text" required name="nbre_article" class="form-control" id="nbreArticle" v-model="formData.nbre_article">
  </div>

  </div>
    <div class="row mb-1">

      <div class="form-group col-md-6">
      <label for="description"><b>Description:</b></label>
      <textarea class="form-control" name="description" id="description" v-model="formData.description"></textarea>
      </div>

      <div class="form-group col-md-6">
        <label for="logo"><b>Logo:</b></label>
        <input type="file" name="logo"  ref="fileInput" @change="uploadImage" class="form-control" id="logo" >
      </div>
    </div>
  <br/>
  <button type="submit" id="btnAddPage"  @click="submitPage" class="btn btn-primary float-end">Submit</button>
</form>
 
</div>


</template>

<script>
export default {
  name: 'EditPageApp',
  props: {
  data : Object
  },
  emits :['emitEditSubmitPage'],
 
  data(){
    return{
      interne:'nouveau test',
        formData: {
        titre: this.data.page.titre,
        description: this.data.page.description,
        nbre_article: this.data.page.nbre_article,
        logo: null,
        apropos: this.data.page.apropos_user,
      },
      
    }
  },
 
  methods:{
    editSubmitForm(event) {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddPage');
      submitBtn.disabled = true;

      console.log(this.formData);

      //redirection vers une autre route
      //this.$router.push({ name: 'dashboard_page_update', params: {id: this.data.page.id} });

      // Effectuez ici toute logique nécessaire, par exemple, soumettez les données à un serveur via une requête AJAX.
      this.$emit('emitEditSubmitPage',this.formData,this.data.page.id);

    },
     uploadImage() {
      var file = this.$refs.fileInput.files[0];
      this.formData.logo= file;

    },
 
  }

}
</script>
