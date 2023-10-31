<template>
      <div class="p-4 ">
        <h4>Categories</h4>
        <ol class="list-unstyled">
          <li v-for='categorie in data' :key="categorie.id">
          <router-link  class="text-decoration-none" :to="{ name: 'article_categorie' , params: { id : categorie.id } }">
              {{categorie.nom}}
          </router-link>
          </li>
        </ol>
      </div>
   
</template>

<script>
export default {
  name: 'AccueilCategorie',
  props: {
    data: Object
  },
 
  data(){
    return{
      interne:'nouveau test',
      
    }
  },
  methods:{
          showCategorie(id){
            console.log(id)
            //utilisant la route
          }
  }

}
</script>
