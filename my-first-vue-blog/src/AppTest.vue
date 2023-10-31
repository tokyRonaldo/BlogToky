
<template>
  <p v-for="todo in todos" :key="todo">
  {{todo}}
  </p>
  <input type="text" v-model="message"><span></span>
  <button v-if="message !='' " @click="ajouterToDo">ici</button>
  <br>
  <br>
  <br>
  <AddTodo @nouvelleTest="ajouterToDo"/>
  <ListToDo v-for="todo in todos" :key="todo" :contenu="todo"/>
</template>
<script>
import AddTodo from './components/AddToDo.vue'
import ListToDo from './components/ListToDo.vue'


export default {
  name: 'AppTest',
   components: {
    AddTodo,
    ListToDo
  },

    data() {
    return {
      message: 'Bonjour depuis le composant App!',
      todos :["test1","test2","test3"]
    };
  },
  methods:{
    ajouterToDo(message){
      this.todos.push(message);
      
    }
  }
}
</script>

