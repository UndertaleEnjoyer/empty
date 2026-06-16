<template>
  <section class="page">
    <h1>Игроки</h1>
    <p>Список игроков с постраничным выводом из таблицы <code>players</code>:</p>

    <DataTable
      :value="players"
      :lazy="true"
      :loading="dataStore.loading"
      :paginator="true"
      :rows="perpage"
      :rowsPerPageOptions="[2, 5, 10]"
      :totalRecords="players_total"
      @page="onPageChange"
      responsive-layout="scroll"
      :first="offset"
    >
      <Column field="id" header="№" />
      <Column field="full_name" header="ФИО игрока" />
      <Column field="position" header="Амплуа" />
    </DataTable>
  </section>
</template>

<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { useDataStore } from '@/stores/dataStore';

export default {
  name: 'Players',
  components: { DataTable, Column },
  data() {
    return {
      dataStore: useDataStore(),
      perpage: 5,
      offset: 0,
    };
  },
  computed: {
    players() {
      return this.dataStore.players;
    },
    players_total() {
      return this.dataStore.players_total;
    },
  },
  mounted() {
    console.log('Players component MOUNTED!');
    this.dataStore.get_players(0, this.perpage);
    this.dataStore.get_players_total();
  },
  methods: {
    onPageChange(event) {
      this.offset = event.first;
      this.perpage = event.rows;
      this.dataStore.get_players(this.offset / this.perpage, this.perpage);
    },
  },
};
</script>

<style scoped>
.page {
  max-width: 720px;
}
code {
  background: #f1f3f5;
  padding: 0.1rem 0.3rem;
  border-radius: 4px;
}
</style>
