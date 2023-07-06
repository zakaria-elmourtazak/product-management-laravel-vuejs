<template>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <router-link to="/" class="navbar-brand">Home</router-link>
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <router-link to="/products" class="nav-link">Products</router-link>
        </li>
      </ul>
      <div>
        <ul class="navbar-nav me-auto mb-2 mb-md-0" v-if="!auth">
          <li class="nav-item">
            <router-link to="/login" class="nav-link">Login</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/register" class="nav-link">Register</router-link>
          </li>
        </ul>
        <ul class="navbar-nav me-auto mb-2 mb-md-0" v-if="auth">
          <li class="nav-item">
            <a href="#" class="nav-link" @click="logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script lang="ts">
import { computed, onMounted } from "vue";
import { useStore } from "vuex";
import router from "../router";
import axios from "../axios";

export default {
  name: "Nav",
  setup() {
    const store = useStore();

    const auth = computed(() => store.state.authenticated);

    const logout = async () => {
     
      // const response = await fetch("http://localhost:8000/api/logout", {
      //   method: "POST",
      //   headers: { "Content-Type": "application/json" },
      //   credentials: "include",
      //   body: JSON.stringify({}), // Add any payload data here
      // });

      const response = await axios.post('/logout')
      
      await router.push("/login");
      axios.defaults.headers.common[
        "Authorization"
      ] = ``;
      store.dispatch("setAuth", false);
    };
    return {
      auth,
      logout,
    };
  },
};
</script>
