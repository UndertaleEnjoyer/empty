<template>
  <section class="page">
    <div class="flex justify-center">
      <form class="team-form" @submit.prevent="saveTeam">
        <!-- Заголовок формы динамический: зависит от режима (isEdit) -->
        <h2 class="form-title">
          {{ isEdit ? 'Редактирование команды' : 'Добавление команды' }}
        </h2>

        <div class="field">
          <InputText
            v-model="form.name"
            type="text"
            placeholder="Наименование команды"
            :invalid="!!fieldErrors.name"
            class="w-full"
          />
          <small v-if="fieldErrors.name" class="err">{{ fieldErrors.name[0] }}</small>
        </div>

        <div class="field">
          <!-- В режиме создания файл обязателен, при редактировании — нет -->
          <label class="file-label">
            <i class="pi pi-upload"></i>
            <span>{{ pictureName || 'Выбрать изображение' }}</span>
            <input
              type="file"
              accept="image/*"
              :required="!isEdit"
              @change="changeCaption"
            />
          </label>
          <small v-if="fieldErrors.picture" class="err">{{ fieldErrors.picture[0] }}</small>
        </div>

        <!-- Текст кнопки динамический: зависит от режима -->
        <Button
          type="submit"
          :label="isEdit ? 'Сохранить' : 'Создать'"
          :loading="dataStore.loading"
          class="w-full"
        />
      </form>
    </div>

    <Toast />
  </section>
</template>

<script>
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Toast from 'primevue/toast';
import { useDataStore } from '@/stores/dataStore';

export default {
  name: 'TeamForm',
  components: { InputText, Button, Toast },
  data() {
    return {
      dataStore: useDataStore(),
      form: { name: '', picture: null },
      pictureName: '',
      fieldErrors: {},
    };
  },
  computed: {
    // Режим редактирования включён, если в маршруте есть id
    isEdit() {
      return !!this.$route.params.id;
    },
    // Идентификатор редактируемой записи из параметров маршрута
    teamId() {
      return this.$route.params.id;
    },
  },
  watch: {
    // Следим за id: как только компонент получит его из роутера —
    // подгружаем данные команды и подставляем в форму.
    teamId: {
      async handler(newId) {
        if (newId) {
          const team = await this.dataStore.get_team(newId);
          if (team) {
            this.form.name = team.name;
            this.form.picture = null; // оставляем null, пока файл не изменён
          }
        } else {
          // id пропал (переход на страницу создания) — очищаем форму
          this.form.name = '';
          this.form.picture = null;
          this.pictureName = '';
        }
      },
      immediate: true, // сработает сразу при загрузке страницы
    },
  },
  methods: {
    changeCaption(event) {
      const file = event.target.files[0] || null;
      this.form.picture = file;
      this.pictureName = file ? file.name : '';
    },
    async saveTeam() {
      this.fieldErrors = {};

      const formData = new FormData();
      formData.append('name', this.form.name);
      if (this.form.picture) {
        formData.append('picture', this.form.picture);
      }

      // В зависимости от режима вызываем обновление или создание
      let result;
      if (this.isEdit) {
        result = await this.dataStore.update_team(formData, this.teamId);
      } else {
        result = await this.dataStore.add_team(formData);
      }

      if (result.ok) {
        this.$toast.add({
          severity: 'success',
          summary: this.isEdit ? 'Команда обновлена' : 'Команда добавлена',
          detail: result.message,
          life: 4000,
        });
        // Возврат к таблице после успешного сохранения
        setTimeout(() => this.$router.push('/teams'), 600);
      } else {
        this.fieldErrors = result.errors || {};
        this.$toast.add({
          severity: 'error',
          summary: this.isEdit ? 'Ошибка обновления данных' : 'Ошибка добавления данных',
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
  padding-top: 1rem;
}
.flex {
  display: flex;
}
.justify-center {
  justify-content: center;
}
.team-form {
  width: 420px;
  max-width: 100%;
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}
.form-title {
  text-align: center;
  color: dimgray;
  font-weight: 500;
}
.field {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}
.w-full {
  width: 100%;
}
.file-label {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  color: #6b7280;
  cursor: pointer;
}
.file-label input[type='file'] {
  display: none;
}
.err {
  color: #ef4444;
}
</style>
