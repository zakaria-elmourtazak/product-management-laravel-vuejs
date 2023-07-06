<script setup>
import { RouterLink, RouterView } from "vue-router";

</script>

<template>
 
  <Nav/>
  <RouterView />
</template>

<script>
import Nav from "./components/Nav.vue";

export default {
  components: {Nav}
}
</script>