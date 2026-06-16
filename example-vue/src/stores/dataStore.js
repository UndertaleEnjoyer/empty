import { defineStore } from 'pinia';
import axios from 'axios';

// Базовый адрес REST API — берётся из .env (VITE_BACKEND_URL)
const backendUrl = import.meta.env.VITE_BACKEND_URL;

// Заголовок авторизации (маршруты данных защищены auth:sanctum)
function authHeader() {
  return { Authorization: 'Bearer ' + localStorage.getItem('token') };
}

export const useDataStore = defineStore('data', {
  state: () => ({
    teams: [],
    teams_total: null,
    players: [],
    players_total: null,
    loading: false,
    errorMessage: '',
  }),
  actions: {
    // --- Команды (таблица teams) ---
    async get_teams(page = 0, perpage = 5) {
      this.errorMessage = '';
      this.loading = true;
      try {
        const response = await axios.get(backendUrl + '/team', {
          params: { page, perpage },
          headers: authHeader(),
        });
        this.teams = response.data;
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
      } finally {
        this.loading = false;
      }
    },
    async get_teams_total() {
      this.errorMessage = '';
      try {
        const response = await axios.get(backendUrl + '/team_total', {
          headers: authHeader(),
        });
        this.teams_total = response.data;
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

    // --- Игроки (таблица players) ---
    async get_players(page = 0, perpage = 5) {
      this.errorMessage = '';
      this.loading = true;
      try {
        const response = await axios.get(backendUrl + '/player', {
          params: { page, perpage },
          headers: authHeader(),
        });
        this.players = response.data;
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
      } finally {
        this.loading = false;
      }
    },
    async get_players_total() {
      this.errorMessage = '';
      try {
        const response = await axios.get(backendUrl + '/player_total', {
          headers: authHeader(),
        });
        this.players_total = response.data;
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
  },
});
