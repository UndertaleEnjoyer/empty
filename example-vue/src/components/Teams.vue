<template>
  <section class="page">
    <h1>Команды</h1>
    <p>Список команд с постраничным выводом из таблицы <code>teams</code>:</p>

    <!-- Кнопка открытия формы добавления -->
    <div class="toolbar">
      <Button
        label="Добавить команду"
        icon="pi pi-plus"
        size="small"
        @click="openDialog"
      />
    </div>

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
      <!-- Отдельный столбец с изображением (логотипом) -->
      <Column header="Логотип">
        <template #body="{ data }">
          <img
            v-if="data.picture_url"
            :src="data.picture_url"
            :alt="data.name"
            class="team-logo"
          />
          <span v-else class="muted">—</span>
        </template>
      </Column>
      <Column field="name" header="Наименование команды" />
    </DataTable>

    <!-- Форма добавления записи -->
    <Dialog
      v-model:visible="dialogVisible"
      header="Новая команда"
      :modal="true"
      :style="{ width: '420px' }"
    >
      <form class="add-form" @submit.prevent="submit">
        <div class="field">
          <label for="team-name">Наименование команды</label>
          <InputText
            id="team-name"
            v-model="form.name"
            placeholder="Например: Торпедо"
            :invalid="!!fieldErrors.name"
          />
          <small v-if="fieldErrors.name" class="err">{{ fieldErrors.name[0] }}</small>
        </div>

        <div class="field">
          <label>Изображение (логотип)</label>
          <input type="file" accept="image/*" @change="onFileSelect" />
          <small v-if="fieldErrors.picture" class="err">{{ fieldErrors.picture[0] }}</small>
        </div>

        <div class="actions">
          <Button
            type="button"
            label="Отмена"
            severity="secondary"
            size="small"
            @click="dialogVisible = false"
          />
          <Button
            type="submit"
            label="Сохранить"
            icon="pi pi-check"
            size="small"
            :loading="dataStore.loading"
          />
        </div>
      </form>
    </Dialog>
  </section>
</template>

<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { useDataStore } from '@/stores/dataStore';

export default {
  name: 'Teams',
  components: { DataTable, Column, Dialog, InputText, Button },
  data() {
    return {
      dataStore: useDataStore(),
      perpage: 5,
      offset: 0,
      dialogVisible: false,
      form: { name: '', picture: null },
      fieldErrors: {},
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
    this.dataStore.get_teams(0, this.perpage);
    this.dataStore.get_teams_total();
  },
  methods: {
    onPageChange(event) {
      this.offset = event.first;
      this.perpage = event.rows;
      this.dataStore.get_teams(this.offset / this.perpage, this.perpage);
    },
    openDialog() {
      this.form = { name: '', picture: null };
      this.fieldErrors = {};
      this.dialogVisible = true;
    },
    onFileSelect(event) {
      this.form.picture = event.target.files[0] || null;
    },
    async submit() {
      this.fieldErrors = {};

      const fd = new FormData();
      fd.append('name', this.form.name);
      if (this.form.picture) {
        fd.append('picture', this.form.picture);
      }

      const result = await this.dataStore.add_team(fd);

      if (result.ok) {
        // Успешное добавление — toast + обновление таблицы
        this.$toast.add({
          severity: 'success',
          summary: 'Успешно',
          detail: result.message,
          life: 3000,
        });
        this.dialogVisible = false;
        this.dataStore.get_teams(this.offset / this.perpage, this.perpage);
        this.dataStore.get_teams_total();
      } else {
        // Ошибка — подсвечиваем поля и показываем toast
        this.fieldErrors = result.errors || {};
        this.$toast.add({
          severity: 'error',
          summary: 'Ошибка',
          detail: result.message,
          life: 5000,
        });
      }
    },
  },
};
</script>

<style scoped>
.page {
  max-width: 720px;
}
.toolbar {
  margin-bottom: 0.75rem;
}
.team-logo {
  width: 40px;
  height: 40px;
  object-fit: contain;
  border-radius: 50%;
  vertical-align: middle;
}
.muted {
  color: #9ca3af;
}
code {
  background: #f1f3f5;
  padding: 0.1rem 0.3rem;
  border-radius: 4px;
}
.add-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.field {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}
.field label {
  font-weight: 600;
  font-size: 0.9rem;
}
.err {
  color: #ef4444;
}
.actions {
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
}
</style>
