<template>
  <header>
    <Menubar :model="items" class="app-menubar">
      <!-- Логотип / название слева -->
      <template #start>
        <span class="brand">
          <i class="pi pi-prime" style="font-size: 1.3rem"></i>
          PrimeVue App
        </span>
      </template>

      <!-- Пункты меню, привязанные к маршрутам -->
      <template #item="{ item, props }">
        <router-link
          v-if="item.route"
          :to="item.route"
          custom
          v-slot="{ href, navigate, isActive }"
        >
          <a
            :href="href"
            v-bind="props.action"
            :class="{ 'active-link': isActive }"
            @click="navigate"
          >
            <span :class="item.icon" />
            <span class="ml-2">{{ item.label }}</span>
          </a>
        </router-link>
      </template>

      <!-- Форма аутентификации справа -->
      <template #end>
        <div class="auth-area">
          <div v-if="isAuthenticated && user" class="auth-user">
            <span>Привет, <strong>{{ user.name }}</strong></span>
            <Button
              label="Выйти"
              icon="pi pi-sign-out"
              severity="secondary"
              size="small"
              @click="logout"
            />
          </div>

          <form v-else class="auth-form" @submit.prevent="login">
            <InputText
              v-model="email"
              type="email"
              placeholder="Email"
              size="small"
              required
            />
            <Password
              v-model="password"
              placeholder="Пароль"
              :feedback="false"
              toggleMask
              inputClass="auth-password-input"
              required
            />
            <Button type="submit" label="Войти" icon="pi pi-sign-in" size="small" />
            <small v-if="authError" class="auth-error">{{ authError }}</small>
          </form>
        </div>
      </template>
    </Menubar>
  </header>

  <main class="app-content">
    <router-view></router-view>
  </main>
</template>

<script>
import { useAuthStore } from '@/stores/authStore'
import Menubar from 'primevue/menubar'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Button from 'primevue/button'

export default {
  components: { Menubar, InputText, Password, Button },
  data() {
    return {
      email: '',
      password: '',
      authStore: useAuthStore(),
      items: [
        { label: 'Главная', icon: 'pi pi-home', route: '/' },
        { label: 'Категории', icon: 'pi pi-tags', route: '/categories' },
        { label: 'Товары', icon: 'pi pi-box', route: '/items' },
      ],
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
      this.authStore.logout()
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
.brand {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 700;
  color: var(--p-primary-color, #10b981);
  margin-right: 1rem;
}
.ml-2 {
  margin-left: 0.5rem;
}
.active-link {
  color: var(--p-primary-color, #10b981) !important;
  font-weight: 700;
}
.auth-area {
  display: flex;
  align-items: center;
}
.auth-user {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}
.auth-form {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-wrap: wrap;
}
.auth-error {
  color: #ef4444;
  width: 100%;
}
.app-content {
  padding: 1.5rem;
}
</style>
