<template>
<div class="container">
  <div class="row ">
    <div class="d-flex justify-content-between ">
      <h3>Categories </H3>
      <button v-if="this.user && this.user.role == 'admin'" @click="ajouterCategorie" class="btn btn-primary ">ajouter</button>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row mt-3">
    <div  class="table-responsive">
      <table  class="table" style="width:100%;" id="my-datatable-categorie">
      <thead>
        <tr>
          <th>Nom</th>
          <th>slug</th>
          <th>Couleur</th>
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
  name: 'IndexCategorieApp',
  props: {
    msg: String
  },
 emits :['createCategorie','editCategorie','deleteCategorie'],
  data(){
    return{
      datatable:null,
      //addArticle:null,
      //editArticle:null,
      dataAddArticle:null,
      dataEditArticle:null,
      user:{},
      apiUrl: process.env.VUE_APP_API_URL
      
    }
  },
   mounted() {
    this.initializeDataTable();
    this.onClickAction();
    this.fetchUser();

     //this.fetchCategories();
  },
  beforeUnmount() {
    this.destroyDataTable();
  },
  methods: {
    initializeDataTable() {
      this.dataTable = $("#my-datatable-categorie").DataTable({
        processing: true,
        serverSide: true, // Activer le mode côté serveur
        //responsive: true,
        paging: true, 
        //pageLength: 10,
        ordering: true,
        //searching: true, 
        order: [[1, 'asc']],
        ajax: {
          url: '${this.apiUrl}/api/categorie', // URL de l'API pour récupérer les données
           datasrc: "data"// Chemin vers les données dans la réponse de l'API
        },
        columns: [
          { data: 'nom',searchable: true },
          { data: 'slug' },
          { data: 'couleur'  },
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
      fetchCategories() {
    axios.get("${this.apiUrl}/api/categorie").then((response) => {
      
      this.dataTable.clear().rows.add(response.data).draw();
    });
  },
  ajouterCategorie(){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_categorie_create' , params: { method :'create' }});

    this.$emit('CreateCategorie',this.addCategorie = 1);
    console.log('ajouter');
  },
  editerCategorie(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_categorie_edit', params: {id: id,method :'edit'} });

    this.$emit('editCategorie',id);
    
  },
   supprimerCategorie(id){
    //redirection vers une autre route
    this.$router.push({ name: 'dashboard_categorie_destroy', params: {id: id} });

    this.$emit('deleteCategorie',id);
    
  },
  onClickAction(){
    const self = this;
   $('#my-datatable-categorie').on('click', '.edit-categorie', function () {
    var id = $(this).attr("id");
    var parts = id.split("-");
    var theId = parts[1];
      //console.log('editer');
        self.editerCategorie(theId);
    });
      $('#my-datatable-categorie').on('click', '.delete-categorie', function () {
        var id = $(this).attr("id");
    var parts = id.split("-");
     var theId = parts[1];
        self.supprimerCategorie(theId)
    });
    
  },
  fetchUser() {
      const token = localStorage.getItem('access_token');
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      axios.get('${this.apiUrl}/api/user/connected') // Appel de la route API pour récupérer l'utilisateur
        .then(response => {
          this.user = response.data; // Mettez à jour la propriété user avec les informations de l'utilisateur
            console.log(this.user)
        })
        .catch(error => {
          console.error(error);
        });
    }
  },
}
</script>
