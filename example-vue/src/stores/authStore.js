import { defineStore } from 'pinia';
import axios from 'axios';

// Базовый адрес REST API (Laravel + Sanctum)
const API_BASE = 'http://127.0.0.1:8000/api';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,        // Данные пользователя
    token: localStorage.getItem('token') || null,  // Токен из localStorage
    isAuthenticated: false,  // Статус аутентификации
    errorMessage: "",
  }),
  actions: {
    async login(credentials) {
      this.errorMessage = "";
      try {
        const response = await axios.post(API_BASE + '/login', credentials);
        this.token = response.data.token;
        this.user = response.data.user;
        this.isAuthenticated = true;
        localStorage.setItem('token', response.data.token);
      } catch (error) {
        if (error.response) {
          // Сервер ответил статусом вне диапазона 2xx
          this.errorMessage = error.response.data.message;
          console.log(error);
        } else if (error.request) {
          // Запрос отправлен, но ответ не получен
          this.errorMessage = error.message;
          console.log(error);
        } else {
          // Ошибка при настройке запроса
          console.log(error);
        }
      }
    },
    async getUser() {
      this.errorMessage = "";
      try {
        const response = await axios.get(API_BASE + '/me', {
          headers: {
            Authorization: 'Bearer ' + this.token,
          },
        });
        this.user = response.data;
        this.isAuthenticated = true;
      } catch (error) {
        if (error.response) {
          this.errorMessage = error.response.data.message;
          console.log(error);
        } else if (error.request) {
          this.errorMessage = error.message;
          console.log(error);
        } else {
          console.log(error);
        }
      }
    },
    async logout() {
      try {
        await axios.post(API_BASE + '/logout', {}, {
          headers: {
            Authorization: 'Bearer ' + this.token,
          },
        });
      } catch (error) {
        console.log(error);
      } finally {
        // Сбрасываем состояние в любом случае
        this.token = null;
        this.user = null;
        this.isAuthenticated = false;
        localStorage.removeItem('token');
      }
    },
  },
});
