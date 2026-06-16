<template>
  <section class="page">
    <h1>Команды</h1>
    <p>Список команд с постраничным выводом из таблицы <code>teams</code>:</p>

    <DataTable
      :value="teams"
      :lazy="true"
      :loading="dataStore.loading"
      :paginator="true"
      :rows="perpage"
      :rowsPerPageOptions="[2, 5, 10]"
      :totalRecords="teams_total"
      @page="onPageChange"
      responsive-layout="scroll"
      :first="offset"
    >
      <Column field="id" header="№" />
      <Column field="name" header="Наименование команды" />
    </DataTable>
  </section>
</template>

<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { useDataStore } from '@/stores/dataStore';

export default {
  name: 'Teams',
  components: { DataTable, Column },
  data() {
    return {
      dataStore: useDataStore(),
      perpage: 5,
      offset: 0,
    };
  },
  computed: {
    teams() {
      return this.dataStore.teams;
    },
    teams_total() {
      return this.dataStore.teams_total;
    },
  },
  mounted() {
    console.log('Teams component MOUNTED!');
    this.dataStore.get_teams(0, this.perpage);
    this.dataStore.get_teams_total();
  },
  methods: {
    onPageChange(event) {
      this.offset = event.first;
      this.perpage = event.rows;
      this.dataStore.get_teams(this.offset / this.perpage, this.perpage);
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
