<template>
 <div class="p-4 mb-3 bg-body-tertiary rounded">
        <h4>Apropos</h4>
        <p v-if="data && data.apropos">
          {{data.apropos.name}}
        </p>
        <p v-if="data && data.apropos">
          {{data.apropos.email}}
        </p>
      </div>

</template>

<script>
export default {
  name: 'AccueilApropos',
  props: {
    data: Object
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
