<template>
  <header>
    <nav>
      <ul>
        <li><router-link to="/">Главная</router-link></li>
        <li><router-link to="/categories">Категории</router-link></li>
        <li><router-link to="/items">Товары</router-link></li>
      </ul>
      <div v-if="isAuthenticated && user">
        Welcome, {{ user.name }}
        <button @click="logout">Logout</button>
      </div>
      <div v-else>
        <form @submit.prevent="login">
          <div>
            <label for="email">Email:</label>
            <input v-model="email" type="email" id="email" required />
          </div>
          <div>
            <label for="password">Password:</label>
            <input v-model="password" type="password" id="password" required />
          </div>
          <button type="submit">Login</button>
          <p v-if="authError" class="error">{{ authError }}</p>
        </form>
      </div>
    </nav>
  </header>
  <router-view></router-view>
</template>

<script>
import { useAuthStore } from '@/stores/authStore'

export default {
  data() {
    return {
      email: '',
      password: '',
      authStore: useAuthStore(),
    }
  },
  computed: {
    isAuthenticated() {
      return this.authStore.isAuthenticated
    },
    user() {
      return this.authStore.user
    },
    authError() {
      return this.authStore.errorMessage
    },
  },
  methods: {
    logout() {
      this.authStore.logout() // Используем authStore для логаута
    },
    login() {
      this.authStore.login({ email: this.email, password: this.password })
    },
  },
  mounted() {
    const token = localStorage.getItem('token')
    if (token) {
      this.authStore.isAuthenticated = true
      this.authStore.getUser()
    }
  },
}
</script>

<style scoped>
header {
  border-bottom: 1px solid #e0e0e0;
  margin-bottom: 1.5rem;
}
nav ul {
  list-style: none;
  display: flex;
  gap: 1.5rem;
  padding: 0;
  margin: 0 0 1rem;
}
nav a {
  text-decoration: none;
  color: #2c3e50;
  font-weight: 600;
  padding: 0.4rem 0.2rem;
}
nav a.router-link-active {
  color: #42b883;
  border-bottom: 2px solid #42b883;
}
.error {
  color: red;
}
</style>
