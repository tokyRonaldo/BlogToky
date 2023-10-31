<template>
<div class="container">
  <div class="row ">
    <div class="d-flex justify-content-between ">
      <h3>Page </H3>
      <button @click="ajouterPage" class="btn btn-primary " v-if="ifEmptyPage == 1">Ajouter</button>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row mt-3">
    <div  class="table-responsive">
      <table  class="table" style="width:100%;" id="my-datatable-page">
      <thead>
        <tr>
          <th>Logo</th>
          <th>Titre</th>
          <th>Description</th>
          <th>Nombre article</th>
          <th>Apropos</th>
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
  name: 'IndexPageApp',
  props: {
    msg: String
  },
 emits :['createPage','editPage','deletePage'],
  data(){
    return{
      datatable : null,
      dataAddPage : null,
      dataEditPage : null,
      ifEmptyPage : null,
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
   mounted() {
    this.initializeDataTable();
    this.onClickAction();
    this.CheckEmptyPage()
     //this.fetchPages();
  },
  beforeUnmount() {
    this.destroyDataTable();
  },
  methods: {
    initializeDataTable() {
      this.dataTable = $("#my-datatable-page").DataTable({
        processing: true,
        serverSide: true, // Activer le mode côté serveur
        //responsive: true,
        paging: true, 
        //pageLength: 10,
        ordering: true,
        //searching: true, 
        order: [[1, 'asc']],
        ajax: {
          url: '${this.apiUrl}/api/page', // URL de l'API pour récupérer les données
           datasrc: "data"// Chemin vers les données dans la réponse de l'API
        },
        columns: [
          { data: 'logo',searchable: false },
          { data: 'titre',searchable: true },
          { data: 'description',searchable: true },
          { data: 'nbre_article' },
          { data: 'apropos'  },
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
    axios.get("${this.apiUrl}/api/page").then((response) => {
      
      this.dataTable.clear().rows.add(response.data).draw();
    });
  },
  ajouterPage(){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_page_create' , params: { method :'create' } });

    this.$emit('createPage',this.addPage = 1);
    console.log('ajouter');
  },
 editerPage(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_page_edit', params: {id: id,method :'edit'} });

    this.$emit('editPage',id);
    
  },
   supprimerPage(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_page_destroy', params: {id: id} });

    this.$emit('deletePage',id);
    
  },
  onClickAction(){
    const self = this;
   $('#my-datatable-page').on('click', '.edit-page', function () {
    var id = $(this).attr("id");
    var parts = id.split("-");
    var theId = parts[1];
      //console.log('editer');
        self.editerPage(theId);
    });
      $('#my-datatable-page').on('click', '.delete-page', function () {
         console.log('effacer');
        var id = $(this).attr("id");
    var parts = id.split("-");
     var theId = parts[1];
      console.log('effacer');

        self.supprimerPage(theId)
    });
    
  },
  CheckEmptyPage(){
      axios.get("${this.apiUrl}/api/page/checkPage").then((response) => {
      if(response.data.page.length == 0){
        this.ifEmptyPage = 1;
      }
    });
  }
  }
}
</script>
