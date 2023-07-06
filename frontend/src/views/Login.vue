<template>
  <main class="form-signin mt-5">
    <form @submit.prevent="submit">
      <h3 class="h3 mb-3 fw-normal">Please sign in</h3>

      <input
        v-model="data.email"
        type="email"
        class="form-control mb-3"
        placeholder="Email"
        required
      />

      <input
        v-model="data.password"
        type="password"
        class="form-control"
        placeholder="Password"
        required
      />

      <button class="w-100 btn btn-lg btn-primary" type="submit">
        Sign in
      </button>
    </form>
  </main>
</template>

<script lang="ts">
import { reactive } from "vue";
import { useRouter } from "vue-router";
import axios from "../axios";
// import axios from 'axios'
export default {
  name: "Login",
  setup() {
    const data = reactive({
      email: "",
      password: "",
    });
    const router = useRouter();

    const submit = async () => {
      const res = await axios.post("/login", data, {
        headers: {
          "Content-Type": "application/json",
        },
        withCredentials: false,
      });
      console.log(res.data.message);

      axios.defaults.headers.common[
        "Authorization"
      ] = `Bearer ${res.data.message}`;
      await router.push("/");
    };

    return {
      data,
      submit,
    };
  },
};
</script>

<style>
.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}

.form-signin .checkbox {
  font-weight: 400;
}

.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}

.form-signin .form-control:focus {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
