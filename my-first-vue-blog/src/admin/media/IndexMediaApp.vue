<template>
<div class="container">
  <div class="row ">
    <div class="d-flex justify-content-between ">
      <h3>Media </H3>
      <button @click="ajouterMedia" class="btn btn-primary ">ajouter</button>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row mt-3">
    <div  class="table-responsive">
      <table  class="table" style="width:100%;" id="my-datatable-media">
      <thead>
        <tr>
          <th>img</th>
          <th>article</th>
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
  name: 'IndexMediaApp',
  props: {
    msg: String
  },
 emits :['createMedia','editMedia','deleteMedia'],
  data(){
    return{
      datatable:null,
      dataAddMedia:null,
      dataEditMedia:null,
      apiUrl: process.env.VUE_APP_API_URL
    }
  },
   mounted() {
  this.initializeDataTable();
    this.onClickAction();
  
     //this.fetchMedia();
  },
  beforeUnmount() {
    this.destroyDataTable();
  },
  methods: {
    initializeDataTable() {
      this.dataTable = $("#my-datatable-media").DataTable({
        processing: true,
        serverSide: true, // Activer le mode côté serveur
        //responsive: true,
        paging: true, 
        //pageLength: 10,
        ordering: true,
        //searching: true, 
        order: [[1, 'asc']],
        ajax: {
          url: `${this.apiUrl}/api/media`, // URL de l'API pour récupérer les données
           datasrc: "data"// Chemin vers les données dans la réponse de l'API
        },
        columns: [
          { data: 'file',searchable: false },
          { data: 'article',searchable: true },
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
    axios.get(`${this.apiUrl}/api/media`).then((response) => {
      
      this.dataTable.clear().rows.add(response.data).draw();
    });
  },
  ajouterMedia(){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_media_create' , params: { method :'create' } });

    this.$emit('createMedia',this.addMedia = 1);
    console.log('ajouter');
  },
 editerMedia(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_media_edit', params: {id: id,method :'edit'} });

    this.$emit('editMedia',id);
    
  },
   supprimerMedia(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_media_destroy', params: {id: id} });

    this.$emit('deleteMedia',id);
    
  },
  onClickAction(){
    const self = this;
   $('#my-datatable-media').on('click', '.edit-media', function () {
    var id = $(this).attr("id");
    var parts = id.split("-");
    var theId = parts[1];
      //console.log('editer');
        self.editerMedia(theId);
    });
      $('#my-datatable-media').on('click', '.delete-media', function () {
        var id = $(this).attr("id");
    var parts = id.split("-");
     var theId = parts[1];
        self.supprimerMedia(theId)
    });
    
  }
  }
}
</script>
