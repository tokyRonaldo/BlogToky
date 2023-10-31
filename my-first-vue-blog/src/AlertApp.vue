<template>
  <div v-if="show" class="alert" :class="alertClass">
    {{ message }}
    <button @click="closeAlert">&times;</button>
  </div>
</template>

<script>
export default {
  name: 'AlertApp',
  props: {
    message: String,
    type: {
      type: String,
      default: 'success'
    }
  },
  data() {
    return {
      show: true
    };
  },
  computed: {
    alertClass() {
      return `alert-${this.type}`;
    }
  },
  methods: {
    closeAlert() {
      this.show = false;
    }
  }
};
</script>

<style scoped>
.alert {
  padding: 15px;
  margin: 10px 0;
  border: 1px solid;
  border-radius: 5px;
  position: relative;
}

.alert-success {
  background-color: #d4edda;
  border-color: #c3e6cb;
  color: #155724;
}

.alert button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 18px;
  color: inherit;
}
</style>
