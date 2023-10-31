<template>
<div class="container">
  <div class="row mb-3">
<h3>Ajouter article </H3>
    
  </div>
  <form @submit="submitForm">
  <div class="row mb-2">
  <div class="form-group col-md-6">
    <label for="titre"><b>Titre:</b></label>
    <input type="text" required name="titre" class="form-control" id="titre" v-model="formData.titre">
  </div>

  </div>
  
  <div class="row mb-1">
  <label ><b>Categories:</b></label>
  <div class="checkbox mb-1" v-for="categorie in data.allCategorie" :key="categorie.id">
      <label><input type="checkbox"  :value="categorie.id" v-model="formData.categories">{{categorie.nom}}</label>
    </div>
   </div>
   
  <div class="form-group">
    <label for="contenu"><b>Contenu:</b></label>
    <textarea class="form-control" name="contenu" required id="contenu" v-model="formData.contenu"></textarea>
  </div>

  <br/>
  <button type="submit" id="btnAddArticle"  class="btn btn-primary float-end">Submit</button>
</form>
 
</div>
<AlertApp v-if="alert.show " class="alertApp" :message="alert.message" :type="alert.type" />

</template>

<script>
import AlertApp from '../../AlertApp.vue';
export default {
  name: 'CreateArticleApp',
  components: {
      AlertApp,
  },
  props: {
  data : Object
  },
 emits :['emitSubmitArticle'],
 
  data(){
    return{
      interne:'nouveau test',
        formData: {
          titre: '',
          contenu: '',
          categories:[],
        },
        alert: {
          show: false,
          message: "",
          type: "success"
        }
      
    }
  },
  methods:{
      submitForm(event) {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddArticle');
      submitBtn.disabled = true;
      console.log(this.formData.categories)
      if(this.formData.categories.length == 0){
         this.showErrorAlert('choisissez une categorie');
      }
      else{
        //redirection vers une autre route
        //this.$router.push({ name: 'dashboard_article_store' });

        // Effectuez ici toute logique nécessaire, par exemple, soumettez les données à un serveur via une requête AJAX.
        this.$emit('emitSubmitArticle',this.formData);

        
      }
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
    
    },
  selectedCategories(){
    
  }
  },
   mounted() {

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


</style>