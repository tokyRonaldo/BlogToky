<template>
<div class="container">
  <div class="row mb-3">
<h3>Editer article </H3>
    
  </div>
  <form @submit="editSubmitForm">
  <div class="row mb-2">
  <div class="form-group col-md-6">
    <label for="titre"><b>Titre:</b></label>
    <input type="text" required name="titre" class="form-control" id="titre" v-model="formData.titre">
  </div>

  </div>
    <div class="row mb-1">
  <label ><b>Categories:</b></label>
  <div class="checkbox mb-1" v-for="categorie in data.allCategorie" :key="categorie.id">
      <label><input type="checkbox"  :checked="isCategorySelected(categorie.id)" :value="categorie.id" v-model="formData.selectedCategories">{{categorie.nom}}</label>
    </div>
   </div>
  <div class="form-group">
    <label for="contenu"><b>Contenu:</b></label>
    <textarea class="form-control" required name="contenu" id="contenu" v-model="formData.contenu"></textarea>
  </div>

  <br/>
  <button type="submit" id="btnAddArticle"  @click="submitArticle" class="btn btn-primary float-end">Submit</button>
</form>
 
</div>
<AlertApp v-if="alert.show" class="alertApp" :message="alert.message" :type="alert.type" />


</template>

<script>
import AlertApp from '../../AlertApp.vue';
export default {
  name: 'EditArticleApp',
    components: {
      AlertApp,
  },
  props: {
  data : Object
  },
  emits :['emitEditSubmitArticle'],
 
  data(){
    return{
      interne:'nouveau test',
        formData: {
        titre: this.data.article.titre,
        contenu: this.data.article.contenu,
        selectedCategories:[],
      },
        alert: {
        show: false,
        message: "",
        type: "success"
      }
      
    }
  },
   created() {
    // Initialisez selectedCategories avec les catégories existantes
    this.formData.selectedCategories = this.data.article_categories.map(article_category => article_category.id);
  },
  methods:{
    editSubmitForm(event) {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddArticle');
      submitBtn.disabled = true;
      console.log(this.formData);
      if(this.formData.selectedCategories.length == 0){
         this.showErrorAlert('choisissez une categorie');
      }
      else{
        //redirection vers une autre route
        //this.$router.push({ name: 'dashboard_article_update', params: {id: this.data.article.id} });

        // Effectuez ici toute logique nécessaire, par exemple, soumettez les données à un serveur via une requête AJAX.
        this.$emit('emitEditSubmitArticle',this.formData,this.data.article.id);
      }
    },
    isCategorySelected(categorieId){
      console.log(this.data.article_categories);
      console.log(categorieId);

      //return result=this.data.article_categories.some(article_category => article_category.id === categorieId);
      return this.formData.selectedCategories.includes(categorieId);
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
   mounted() {
   console.log(this.data);
 
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