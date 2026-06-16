<template>
  <section class="page">
    <h1>Товары</h1>
    <p>Каталог доступных товаров:</p>
    <table class="items">
      <thead>
        <tr>
          <th>Название</th>
          <th>Категория</th>
          <th>Цена</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>{{ item.name }}</td>
          <td>{{ item.category }}</td>
          <td>{{ item.price }} ₽</td>
        </tr>
      </tbody>
    </table>
  </section>
</template>

<script>
export default {
  name: 'ItemsView',
  data() {
    return {
      items: [
        { id: 1, name: 'Ноутбук', category: 'Электроника', price: 79990 },
        { id: 2, name: 'Смартфон', category: 'Электроника', price: 49990 },
        { id: 3, name: 'Учебник по Vue.js', category: 'Книги', price: 1290 },
        { id: 4, name: 'Футболка', category: 'Одежда', price: 1990 },
        { id: 5, name: 'Футбольный мяч', category: 'Спорт', price: 2490 },
      ],
    }
  },
}
</script>

<style scoped>
.page {
  max-width: 720px;
}
.items {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}
.items th,
.items td {
  text-align: left;
  padding: 0.6rem 0.75rem;
  border-bottom: 1px solid #e0e0e0;
}
.items thead th {
  background: #f1f3f5;
}
</style>
