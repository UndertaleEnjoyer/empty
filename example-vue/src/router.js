import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/components/Home.vue';
import Teams from '@/components/Teams.vue';
import Players from '@/components/Players.vue';
import TeamForm from '@/components/TeamForm.vue';
const routes = [
  {
    path: '/',
    component: Home,
  },
  {
    path: '/teams',
    component: Teams,
  },
  {
    path: '/players',
    component: Players,
  },
  {
    // Создание новой команды
    path: '/teams/new',
    component: TeamForm,
  },
  {
    // Редактирование существующей команды (id передаётся в маршруте)
    path: '/teams/edit/:id',
    component: TeamForm,
  },
];
const router = createRouter({
  history: createWebHistory(), // Используем режим истории HTML5
  routes, // Список маршрутов
});
export default router;
