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
    errorCode: 0,
  }),
  actions: {
    // --- Добавление команды с загрузкой изображения ---
    // Возвращает объект { ok, message, errors } для показа toast в компоненте.
    async add_team(formData) {
      this.errorMessage = '';
      this.loading = true;
      try {
        const response = await axios.post(backendUrl + '/team', formData, {
          headers: {
            ...authHeader(),
            'Content-Type': 'multipart/form-data',
          },
        });
        return { ok: true, message: response.data.message, errors: {} };
      } catch (error) {
        if (error.response) {
          // 422 — ошибки валидации, 503 — S3 недоступен и т.д.
          this.errorMessage = error.response.data.message;
          return {
            ok: false,
            message: error.response.data.message,
            errors: error.response.data.errors || {},
          };
        } else if (error.request) {
          // Запрос ушёл, но ответа нет (backend недоступен)
          this.errorMessage = error.message;
          return { ok: false, message: 'Сервер недоступен: ' + error.message, errors: {} };
        }
        return { ok: false, message: 'Неизвестная ошибка', errors: {} };
      } finally {
        this.loading = false;
      }
    },

    // --- Получение одной команды по id (для формы редактирования) ---
    async get_team(id) {
      this.errorMessage = '';
      try {
        const response = await axios.get(backendUrl + '/team/' + id, {
          headers: authHeader(),
        });
        return response.data;
      } catch (error) {
        this.errorMessage = error.message;
        console.log(error);
        return null;
      }
    },

    // --- Удаление команды ---
    // Бэкенд возвращает { code, message|error }. code=0 — успех, иначе ошибка.
    async delete_team(id) {
      this.errorMessage = '';
      this.errorCode = 0;
      try {
        const response = await axios.delete(backendUrl + '/team/' + id, {
          headers: authHeader(),
        });
        this.errorCode = response.data.code;
        // На успех приходит message, на бизнес-ошибку — error
        this.errorMessage = response.data.message ?? response.data.error;
      } catch (error) {
        if (error.response) {
          // 401 — нет прав на удаление, 4xx/5xx — прочие ошибки
          this.errorCode = error.response.data.code ?? 11;
          this.errorMessage = error.response.data.message;
          console.log(error);
        } else if (error.request) {
          this.errorCode = 12;
          this.errorMessage = error.message;
          console.log(error);
        } else {
          this.errorCode = 13;
          console.log(error);
        }
      }
    },

    // --- Обновление (редактирование) команды ---
    // Возвращает { ok, message, errors } для показа toast в компоненте.
    async update_team(formData, id) {
      this.errorMessage = '';
      this.loading = true;
      try {
        const response = await axios.post(backendUrl + '/team/' + id, formData, {
          headers: {
            ...authHeader(),
            'Content-Type': 'multipart/form-data',
          },
        });
        return { ok: response.data.code === 0, message: response.data.message, errors: {} };
      } catch (error) {
        if (error.response) {
          // 422 — ошибки валидации, 401 — нет прав, 500 — ошибка сервера
          this.errorMessage = error.response.data.message;
          return {
            ok: false,
            message: error.response.data.message,
            errors: error.response.data.errors || {},
          };
        } else if (error.request) {
          this.errorMessage = error.message;
          return { ok: false, message: 'Сервер недоступен: ' + error.message, errors: {} };
        }
        return { ok: false, message: 'Неизвестная ошибка', errors: {} };
      } finally {
        this.loading = false;
      }
    },

    // --- Команды (таблица teams) ---
    // search — подстрока для фильтрации записей по наименованию.
    async get_teams(page = 0, perpage = 5, search = '') {
      this.errorMessage = '';
      this.loading = true;
      try {
        const response = await axios.get(backendUrl + '/team', {
          params: { page, perpage, search },
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
    async get_teams_total(search = '') {
      this.errorMessage = '';
      try {
        const response = await axios.get(backendUrl + '/team_total', {
          params: { search },
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
