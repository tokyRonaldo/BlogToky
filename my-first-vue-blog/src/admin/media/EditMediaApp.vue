<template>
<div class="container">
  <div class="row mb-3">
<h3>Editer media </H3>
    
  </div>
  <form @submit="editSubmitForm">
  <div class="row mb-2">
   <div class="form-group col-md-4">
    <label for="article"><b>Article:</b></label>
    <select required name="article" v-model="formData.article" class="form-control">
    <option disabled :value="null" >choisissez l'article</option>
    <option :value="article.id"  v-for="article in data.allArticle" :key="article.id">{{article.titre}}</option>
    </select>
  </div>
   <div class="form-group col-md-3">
    <label for="alt"><b>Alt:</b></label>
    <input type="alt" name="alt" class="form-control" id="alt" v-model="formData.alt">
  </div>

    <div class="form-group col-md-5">
        <label for="file"><b>File:</b></label>
        <input type="file" name="file" required ref="fileInput" @change="uploadImage" class="form-control" id="file" >
      </div>
    </div>
  <br/>
  <button type="submit" id="btnAddMeda"  @click="submitPage" class="btn btn-primary float-end">Submit</button>
</form>
 
</div>


</template>

<script>
export default {
  name: 'EditMediaApp',
  props: {
  data : Object
  },
  emits :['emitEditSubmitMedia'],
 
  data(){
    return{
      interne:'nouveau test',
        formData: {
        article: this.data.media.article_id,
        alt: this.data.media.alt,
        file: null,
      },
      
    }
  },
  methods:{
    editSubmitForm(event) {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddMeda');
      submitBtn.disabled = true;

      console.log(this.formData);
      if (this.formData.article) {
     //redirection vers une autre route
      //this.$router.push({ name: 'dashboard_media_update', params: {id: this.data.media.id} });

      // Le champ de sélection a une option sélectionnée
      // Effectuez ici toute logique nécessaire, par exemple, soumettez les données à un serveur via une requête AJAX.
      this.$emit('emitEditSubmitMedia',this.formData,this.data.media.id);

      }
      else{
        alert("Veuillez sélectionner une article !");

      }
    },
     uploadImage() {
      var file = this.$refs.fileInput.files[0];
      this.formData.file= file;

      // Envoyer le formulaire au serveur (Laravel) pour l'enregistrement de l'image
      // Utilisez Axios ou un autre client HTTP pour cela
    },

  }

}
</script>
