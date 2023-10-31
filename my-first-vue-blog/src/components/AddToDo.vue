<template>
  <div class="hello">

  <input type="text" v-model="interne"><span></span>
  <button v-if="interne !='' " @click="addToDo">ici</button>
  
   
  </div>
</template>

<script>
export default {
  name: 'AddToDo',
  props: {
    msg: String
  },
  $emits :['nouvelleTest'],
  data(){
    return{
      interne:'nouveau test',
      
    }
  },
  methods:{
    addToDo(){
      this.$emit('nouvelleTest',this.interne);
      this.interne="";
    }
  }

}
</script>
