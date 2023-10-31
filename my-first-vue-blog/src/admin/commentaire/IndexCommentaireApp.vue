<template>
<div class="container">
  <div class="row ">
    <div class="d-flex justify-content-between ">
      <h3>Commentaires </H3>
      
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row mt-3">
    <div  class="table-responsive">
      <table  class="table" style="width:100%;" id="my-datatable-commentaire">
      <thead>
        <tr>
          <th>Actions</th>
          <th>Article</th>
          <th>Utilisateur</th>
          <th>Commentaire</th>
          <th>createdAt</th>
          <th>updatedAt</th>
        </tr>
      </thead>

      <tbody>
      </tbody>
      </table>
    </div>
  </div>
</div>


</template>

<script>
import $ from 'jquery'
import axios from "axios";

export default {
  name: 'IndexCommentaireApp',
  props: {
    msg: String
  },
 emits :['createCommentaire','editCommentaire','deleteCommentaire'],
  data(){
    return{
      datatable:null,
      //addArticle:null,
      //editArticle:null,
      dataAddCommentaire:null,
      dataEditCommentaire:null,
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
   mounted() {
  this.initializeDataTable();
    this.onClickAction();
  
     //this.fetchArticles();
  },
  beforeUnmount() {
    this.destroyDataTable();
  },
  methods: {
    initializeDataTable() {
      this.dataTable = $("#my-datatable-commentaire").DataTable({
        processing: true,
        serverSide: true, // Activer le mode côté serveur
        //responsive: true,
        paging: true, 
        //pageLength: 10,
        ordering: true,
        //searching: true, 
        order: [[1, 'asc']],
        ajax: {
          url: '${this.apiUrl}/api/commentaire', // URL de l'API pour récupérer les données
           datasrc: "data"// Chemin vers les données dans la réponse de l'API
        },
        columns: [
          { data: 'action',searchable:false  },
          { data: 'article',searchable: true },
          { data: 'utilisateur' },
          { data: 'commentaire'  },
          // Ajoutez d'autres colonnes ici
        ],
      });
    },
    destroyDataTable() {
      if (this.dataTable !== null) {
        this.dataTable.destroy();
        this.dataTable = null;
      }
    },
      fetchArticles() {
    axios.get("${this.apiUrl}/api/commentaire").then((response) => {
      
      this.dataTable.clear().rows.add(response.data).draw();
    });
  },
  ajouterCommentaire(){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_commentaire_create' , params: { method :'create' } });

    this.$emit('createCommentaire',this.addCommentaire = 1);
    console.log('ajouter');
  },
 editerCommentaire(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_commentaire_edit', params: {id: id,method :'edit'} });

    this.$emit('editCommentaire',id);
    
  },
   supprimerCommentaire(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_commentaire_destroy', params: {id: id} });

    this.$emit('deleteCommentaire',id);
    
  },
  onClickAction(){
    const self = this;
   $('#my-datatable-commentaire').on('click', '.edit-commentaire', function () {
    var id = $(this).attr("id");
    var parts = id.split("-");
    var theId = parts[1];
      //console.log('editer');
        self.editerCommentaire(theId);
    });
      $('#my-datatable-commentaire').on('click', '.delete-commentaire', function () {
        var id = $(this).attr("id");
    var parts = id.split("-");
     var theId = parts[1];
        self.supprimerCommentaire(theId)
    });
    
  }
  }
}
</script>
