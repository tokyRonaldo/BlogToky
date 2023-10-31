<template>
<div class="container">
  <div class="row mb-3">
<h3>Editer commentaire </H3>
    
  </div>
  <form @submit="editSubmitForm">
  <div class="row mb-2">
  <div class="form-group col-md-6">
    <label for="article"><b>Article:</b></label>
    <select name="article" class="form-control">
    <option >{{ this.data.article.titre}}</option>
   
    </select>
  </div>
    <div class="form-group col-md-6">
    <label for="user"><b>Utilisateur:</b></label>
    <select name="utilisateur" class="form-control">
    <option  >{{ this.data.user.name}}</option>
    </select>
  </div>
 

  </div>
   
  <div class="form-group">
    <label for="commentaire"><b>Commentaire:</b></label>
    <textarea class="form-control" name="commentaire" id="commentaire" v-model="formData.commentaire"></textarea>
  </div>

  <br/>
  <button type="submit" id="btnAddCommentaire"  @click="submitCommentaire" class="btn btn-primary float-end">Submit</button>
</form>
 
</div>


</template>

<script>
export default {
  name: 'EditCommentaireApp',
  props: {
  data : Object
  },
  emits :['emitEditSubmitCommentaire'],
 
  data(){
    return{
      interne:'nouveau test',
        formData: {
        article: this.data.article.id,
        commentaire: this.data.commentaire.contenu,
        user: this.data.user.id,
      },
      
    }
  },
  
  methods:{
    editSubmitForm(event) {
      event.preventDefault(); // Empêche la soumission du formulaire par défaut
       const submitBtn = document.getElementById('btnAddCommentaire');
      submitBtn.disabled = true;

      console.log(this.formData);

      //redirection vers une autre route
      //this.$router.push({ name: 'dashboard_commentaire_update', params: {id: this.data.commentaire.id} });

      // Effectuez ici toute logique nécessaire, par exemple, soumettez les données à un serveur via une requête AJAX.
      this.$emit('emitEditSubmitCommentaire',this.formData,this.data.commentaire.id);

    },
 
  },
   mounted() {
   console.log(this.data);
 
  },

}
</script>
