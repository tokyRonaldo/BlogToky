<template>
 <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid col-8">
  
    <div class="navbar-header">
      <H2 class="navbar-brand" >Monblog</H2>
    </div>

    <div class="nav navbar-nav navbar-right">
      <router-link  class="nav-link" :to="{ name: 'app_home' }">
          Accueil
      </router-link>
    </div>  
    
  </div>
</nav>
</template>

<script>
export default {
  name: 'NavbarAuthApp',
  props: {
    msg: String
  },
 
  data(){
    return{
      interne:'nouveau test',
      
    }
  },
  methods:{
  
  }

}
</script>
