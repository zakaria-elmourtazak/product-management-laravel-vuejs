<template>
 <div class="contianer text-center">
  <h1> {{ message }}</h1>
 </div>
</template>

<script lang="ts">
import {onMounted, ref} from 'vue';
import {useStore} from "vuex";
import axios from "../axios";

export default {
  name: "Home",
  setup() {
    const message = ref('You are not logged in!');
    const store = useStore();

    onMounted(async () => {
      try {
        const response = await axios.get('/user');


        const content = await response.data;

        message.value = `Hi ${content.name}`;

        await store.dispatch('setAuth', true);
      } catch (e) {
        await store.dispatch('setAuth', false);
      }
    });

    return {
      message
    }
  }
}
</script>
