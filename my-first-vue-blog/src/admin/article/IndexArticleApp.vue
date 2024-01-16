<template>
<div class="container">
  <div class="row ">
    <div class="d-flex justify-content-between ">
      <h3>Articles </H3>
<router-link class="btn btn-primary" @click="ajouterArticle" :to="{ name: 'dashboard_article_create' , params: { method :'create' } }">ajouter</router-link>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row mt-3">
    <div  class="table-responsive">
      <table  class="table" style="width:100%;" id="my-datatable-article">
      <thead>
        <tr>
          <th>Titre</th>
          <th>slug</th>
          <th>contenu</th>
          <th>createdAt</th>
          <th>updatedAt</th>
          <th>Actions</th>
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
  name: 'IndexArticleApp',
  props: {
    msg: String,
      id: {
      type: String,
      default: '',
    },
    method: {
      type: String,
      default: '',
    },
  },
 emits :['createArticle','editArticle','deleteArticle'],
  data(){
    return{
      datatable:null,
      //addArticle:null,
      //editArticle:null,
      dataAddArticle:null,
      dataEditArticle:null,
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
   mounted() {
    console.log('index article');
  this.initializeDataTable();
    this.onClickAction();
  
     //this.fetchArticles();
  },
  beforeUnmount() {
    this.destroyDataTable();
  },
  methods: {
    initializeDataTable() {
      this.dataTable = $("#my-datatable-article").DataTable({
        processing: true,
        serverSide: true, // Activer le mode côté serveur
        //responsive: true,
        paging: true, 
        //pageLength: 10,
        ordering: true,
        //searching: true, 
        order: [[1, 'asc']],
        ajax: {
          url: `${this.apiUrl}/api/article`, // URL de l'API pour récupérer les données
           datasrc: "data"// Chemin vers les données dans la réponse de l'API
        },
        columns: [
          { data: 'titre',searchable: true },
          { data: 'slug' },
          { data: 'contenu'  },
          { data: 'created_at'  },
          { data: 'updated_at'  },
          { data: 'action',searchable:false  },
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
    axios.get(`${this.apiUrl}/api/article`).then((response) => {
      
      this.dataTable.clear().rows.add(response.data).draw();
    });
  },
  ajouterArticle(){
    this.$emit('createArticle',this.addArticle = 1);
  },
  editerArticle(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_article_edit', params: { id: id,method :'edit' } });
    this.$emit('editArticle',id);
    
  },
   supprimerArticle(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_article_destroy', params: { id: id } });
    this.$emit('deleteArticle',id);
    
  },
  onClickAction(){
    const self = this;
    $('#my-datatable-article').on('click', '.edit-article', function () {
        var id = $(this).attr("id");
        var parts = id.split("-");
        var theId = parts[1];
        self.editerArticle(theId);
    });
      $('#my-datatable-article').on('click', '.delete-article', function () {
        var id = $(this).attr("id");
        var parts = id.split("-");
        var theId = parts[1];
        self.supprimerArticle(theId)
    });
    
  }
  }
}
</script>
