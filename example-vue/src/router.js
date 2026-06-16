import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/components/Home.vue';
import Items from '@/components/Items.vue';
import Categories from "@/components/Categories.vue";
const routes = [
  {
    path: '/',
    component: Home,
  },
  {
    path: '/categories',
    component: Categories,
  },
  {
    path: '/items',
    component: Items,
  },
];
const router = createRouter({
  history: createWebHistory(), // Используем режим истории HTML5
  routes, // Список маршрутов
});
export default router;
