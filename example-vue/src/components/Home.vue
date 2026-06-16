<template>
  <section class="page">
    <h1>Главная</h1>
    <p>
      Добро пожаловать в демонстрационное приложение на Vue 3 с использованием
      <strong>Vue Router</strong>. Используйте меню сверху, чтобы переходить
      между разделами — содержимое будет меняться без перезагрузки страницы.
    </p>
    <ul class="features">
      <li>Маршрутизация на стороне клиента (SPA)</li>
      <li>Три отдельных Vue-компонента: «Главная», «Команды», «Игроки»</li>
      <li>Навигация через <code>&lt;router-link&gt;</code> и <code>&lt;router-view&gt;</code></li>
    </ul>
  </section>
</template>

<script>
export default {
  name: 'HomeView',
}
</script>

<style scoped>
.page {
  max-width: 720px;
}
.features {
  margin-top: 1rem;
  line-height: 1.7;
}
code {
  background: #f1f3f5;
  padding: 0.1rem 0.3rem;
  border-radius: 4px;
}
</style>
