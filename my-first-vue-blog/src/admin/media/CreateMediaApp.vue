<template>
<div class="container">
  <div class="row mb-3">
<h3>Ajouter media </H3>
    
  </div>
   <form @submit="submitForm">
  <div class="row mb-2">
 
  <div class="form-group col-md-4">
    <label for="article"><b>Article:</b></label>
    <select required name="article" v-model="formData.article" class="form-control">
    <option disabled value="" selected>choisissez l'article</option>
    <option :value="article.id"  v-for="article in data.allArticle" :key="article.id">{{article.titre}}</option>
    </select>
  </div>
   <div class="form-group col-md-3">
    <label for="alt"><b>Alt:</b></label>
    <input type="alt" name="alt" class="form-control" id="alt" v-model="formData.alt">
  </div>

    <div class="form-group col-md-5">
        <label for="file"><b>File:</b></label>
        <input type="file" required name="file" ref="fileInput" @change="uploadImage" class="form-control" id="file" >
      </div>

  </div>

  <br/>
  <button type="submit" id="btnAddMeda"  @click="submitMedia" class="btn btn-primary float-end">Submit</button>
</form>
 
</div>


</template>

<script>
export default {
  name: 'CreateMediaApp',
  props: {
  data : Object
  },
 emits :['emitSubmitMedia'],
 
  data(){
    return{
      interne:'nouveau test',
         formData: {
        article: '',
        file: null,
        alt: '',
      },
      
    }
  },
  methods:{
      submitForm(event) {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
      const submitBtn = document.getElementById('btnAddMeda');
      submitBtn.disabled = true;

      console.log(this.formData);

      //redirection vers une autre route
      //this.$router.push({ name: 'dashboard_media_store' });

      // Effectuez ici toute logique nécessaire, par exemple, soumettez les données à un serveur via une requête AJAX.
      this.$emit('emitSubmitMedia',this.formData);

    },
     uploadImage() {
      var file = this.$refs.fileInput.files[0];
      this.formData.file= file;

      // Envoyer le formulaire au serveur (Laravel) pour l'enregistrement de l'image
      // Utilisez Axios ou un autre client HTTP pour cela
    },
 
  },
   

}
</script>
