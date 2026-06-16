<template>
  <section class="page">
    <h1>Категории</h1>
    <p>Список категорий товаров в магазине:</p>
    <ul class="cards">
      <li v-for="category in categories" :key="category.id" class="card">
        <span class="icon">{{ category.icon }}</span>
        <div>
          <h3>{{ category.name }}</h3>
          <p>{{ category.count }} товаров</p>
        </div>
      </li>
    </ul>
  </section>
</template>

<script>
export default {
  name: 'CategoriesView',
  data() {
    return {
      categories: [
        { id: 1, name: 'Электроника', icon: '💻', count: 42 },
        { id: 2, name: 'Книги', icon: '📚', count: 128 },
        { id: 3, name: 'Одежда', icon: '👕', count: 76 },
        { id: 4, name: 'Спорт', icon: '⚽', count: 31 },
      ],
    }
  },
}
</script>

<style scoped>
.page {
  max-width: 720px;
}
.cards {
  list-style: none;
  padding: 0;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1rem;
}
.card {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  background: #fff;
}
.icon {
  font-size: 2rem;
}
.card h3 {
  margin: 0;
}
.card p {
  margin: 0;
  color: #777;
  font-size: 0.9rem;
}
</style>
