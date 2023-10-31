<template>
<div class="container">
  <div class="row mb-3">
<h3>Ajouter categorie </H3>
    
  </div>
  <form @submit="submitForm">
  <div class="row mb-2">
  <div class="form-group col-md-6">
    <label for="nom"><b>Nom:</b></label>
    <input type="text" required name="nom" class="form-control" id="nom" v-model="formData.nom">
  </div>
  </div>
  <div class="row mb-1">
 <div class="form-group col-md-4">
    <label for="couleur"><b>Couleur:</b></label>
    <input type="color" required name="couleur" class="form-control" id="couleur" v-model="formData.couleur">
  </div>

  </div>

  <br/>
  <button type="submit" id="btnAddCategorie"  class="btn btn-primary float-end">Submit</button>
</form>
 
</div>

</template>

<script>
export default {
  name: 'CreateCategorieApp',
  props: {
  data : Object
  },
 emits :['emitSubmitCategorie'],
 
  data(){
    return{
      interne:'nouveau test',
         formData: {
        nom: '',
        couleur: '#ff0000',
      },
      
    }
  },
  methods:{
      submitForm(event) {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddCategorie');
      submitBtn.disabled = true;
      console.log(this.formData);

      //redirection vers une autre route
      //this.$router.push({ name: 'dashboard_categorie_store' });

      // Effectuez ici toute logique nécessaire, par exemple, soumettez les données à un serveur via une requête AJAX.
      this.$emit('emitSubmitCategorie',this.formData);

    },
  selectedCategories(){
    
  }
  },
   mounted() {
   console.log(this.data);
     //this.fetchArticles();
  },

}
</script>
