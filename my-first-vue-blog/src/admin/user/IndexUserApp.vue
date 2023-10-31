<template>
<div class="container">
  <div class="row ">
    <div class="d-flex justify-content-between ">
      <h3>Utilisateur </H3>
      <button @click="ajouterUser" class="btn btn-primary ">ajouter</button>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row mt-3">
    <div  class="table-responsive">
      <table  class="table" style="width:100%;" id="my-datatable-user">
      <thead>
        <tr>
          <th>Username</th>
          <th>Role</th>
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
  name: 'IndexUserApp',
  props: {
    msg: String
  },
 emits :['createUser','editUser','deleteUser'],
  data(){
    return{
      datatable:null,
      dataAddUser:null,
      dataEditUser:null,
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
   mounted() {
  this.initializeDataTable();
    this.onClickAction();
  
     //this.fetchUsers();
  },
  beforeUnmount() {
    this.destroyDataTable();
  },
  methods: {
    initializeDataTable() {
      this.dataTable = $("#my-datatable-user").DataTable({
        processing: true,
        serverSide: true, // Activer le mode côté serveur
        //responsive: true,
        paging: true, 
        //UserLength: 10,
        ordering: true,
        //searching: true, 
        order: [[1, 'asc']],
        ajax: {
          url: '${this.apiUrl}/api/user', // URL de l'API pour récupérer les données
           datasrc: "data"// Chemin vers les données dans la réponse de l'API
        },
        columns: [
          { data: 'username',searchable: true },
          { data: 'role'  },
          { data: 'created_at'  },
          { data: 'updated_at'  },
          { data: 'action',searchable:false  }
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
    axios.get("${this.apiUrl}/api/user").then((response) => {
      
      this.dataTable.clear().rows.add(response.data).draw();
    });
  },
  ajouterUser(){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_user_create' , params: { method :'create' } });

    this.$emit('createUser',this.addUser = 1);
    console.log('ajouter');
  },
 editerUser(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_user_edit', params: {id: id,method :'edit'} });

    this.$emit('editUser',id);
    
  },
   supprimerUser(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_user_destroy', params: {id: id} });

    this.$emit('deleteUser',id);
    
  },
  onClickAction(){
    const self = this;
   $('#my-datatable-user').on('click', '.edit-user', function () {
    var id = $(this).attr("id");
    var parts = id.split("-");
    var theId = parts[1];
      //console.log('editer');
        self.editerUser(theId);
    });
      $('#my-datatable-user').on('click', '.delete-user', function () {
        var id = $(this).attr("id");
    var parts = id.split("-");
     var theId = parts[1];
        self.supprimerUser(theId)
    });
    
  }
  }
}
</script>
