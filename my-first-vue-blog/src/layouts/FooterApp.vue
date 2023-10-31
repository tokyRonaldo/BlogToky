<template>
<div class="container col-8">
<footer class="d-flex flex-wrap justify-content-between align-items-center border-top">
<span class="copyright">© {{anneeActuelle}} Monblog. Tous droits reservés
</span>
</footer>
</div>

</template>

<script>
export default {
  name: 'FooterAppApp',
  props: {
    msg: String
  },
 
  data(){
    return{
      interne:'nouveau test',
      anneeActuelle: new Date().getFullYear()
      
    }
  },
  methods:{
  
  }

}
</script>
