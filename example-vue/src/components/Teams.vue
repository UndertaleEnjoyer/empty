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
      <!-- Шапка таблицы: поле ввода подстроки и кнопка поиска -->
      <template #header>
        <div class="table-header">
          <InputText
            v-model="search"
            type="text"
            id="search"
            placeholder="Наименование"
            class="m-2"
            @keyup.enter="onPushSearchButton"
          />
          <Button
            type="button"
            @click="onPushSearchButton"
            icon="pi pi-search"
            label="Найти"
          />
        </div>
      </template>

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

      <!-- Столбец с кнопками действий: удаление и редактирование -->
      <Column class="actions-col" header="Действия">
        <template #body="{ data }">
          <div class="row-actions">
            <Button
              icon="pi pi-times-circle"
              severity="secondary"
              rounded
              @click="openPopupConfirm($event, data)"
            />
            <Button
              icon="pi pi-file-edit"
              severity="secondary"
              rounded
              @click="selectRow(data)"
            />
          </div>
        </template>
      </Column>
    </DataTable>

    <!-- Кнопка перехода к форме создания записи -->
    <div class="toolbar">
      <Button
        label="Добавить команду"
        icon="pi pi-plus"
        @click="$router.push('/teams/new')"
      />
    </div>

    <!-- Всплывающее окно подтверждения удаления и контейнер уведомлений -->
    <ConfirmPopup></ConfirmPopup>
    <Toast></Toast>
  </section>
</template>

<script>
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import ConfirmPopup from 'primevue/confirmpopup';
import Toast from 'primevue/toast';
import { useDataStore } from '@/stores/dataStore';

export default {
  name: 'Teams',
  components: { DataTable, Column, InputText, Button, ConfirmPopup, Toast },
  data() {
    return {
      dataStore: useDataStore(),
      perpage: 5,
      offset: 0,
      search: '',
    };
  },
  computed: {
    teams() {
      return this.dataStore.teams;
    },
    teams_total() {
      return this.dataStore.teams_total;
    },
    error_code() {
      return this.dataStore.errorCode;
    },
    error_message() {
      return this.dataStore.errorMessage;
    },
  },
  mounted() {
    this.dataStore.get_teams(0, this.perpage, this.search);
    this.dataStore.get_teams_total(this.search);
  },
  methods: {
    onPageChange(event) {
      this.offset = event.first;
      this.perpage = event.rows;
      // Пагинация сохраняет текущую подстроку поиска
      this.dataStore.get_teams(this.offset / this.perpage, this.perpage, this.search);
    },
    // Обработчик нажатия на кнопку поиска
    onPushSearchButton() {
      this.offset = 0;
      this.dataStore.get_teams_total(this.search);
      this.dataStore.get_teams(0, this.perpage, this.search);
    },
    // Переход к форме редактирования выбранной записи
    selectRow(data) {
      this.$router.push('/teams/edit/' + data.id);
    },
    // Активация всплывающего окна-подтверждения удаления
    openPopupConfirm(event, data) {
      this.$confirm.require({
        target: event.currentTarget,
        message: 'Вы уверены, что хотите удалить запись ' + data.id + '?',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Да',
        rejectLabel: 'Нет',
        accept: () => {
          this.deleteTeam(data.id);
        },
      });
    },
    // Удаление записи с выводом результата в Toast
    async deleteTeam(id) {
      await this.dataStore.delete_team(id);
      if (this.error_code > 0) {
        this.$toast.add({
          severity: 'error',
          summary: 'Ошибка удаления команды ' + id,
          detail: this.error_message + ' ' + this.error_code,
          life: 4000,
        });
      } else {
        this.$toast.add({
          severity: 'success',
          summary: 'Команда ' + id + ' успешно удалена',
          detail: this.error_message,
          life: 4000,
        });
        // Обновляем текущую страницу и общее количество с учётом поиска
        this.dataStore.get_teams(this.offset / this.perpage, this.perpage, this.search);
        this.dataStore.get_teams_total(this.search);
      }
    },
  },
};
</script>

<style scoped>
.page {
  max-width: 760px;
}
.table-header {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.toolbar {
  margin-top: 0.75rem;
  display: flex;
  justify-content: flex-end;
}
.row-actions {
  display: flex;
  gap: 0.5rem;
  justify-content: flex-end;
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
</style>
