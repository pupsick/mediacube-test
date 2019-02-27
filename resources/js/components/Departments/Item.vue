<template>
    <div>
        <h1>Редактирование сотрудника</h1>
        <form class="my-5">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Название</label>
                <div class="col-sm-5">
                    <input type="text" v-model="department.name" class="form-control" placeholder="Название отдела">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Добавлен в базу</label>
                <div class="col-sm-5">
                    <input type="text" :value="department.created_at" disabled class="form-control">
                </div>
            </div>
            <div class="form-controls mt-4">
                <button :disabled="sending" type="submit" @click.prevent="updateModel" class="btn btn-primary">Сохранить</button>
                <button :disabled="sending" type="submit" @click.prevent="resetModel" class="btn btn-info">Отменить</button>
                <button :disabled="sending" type="submit" @click.prevent="deleteModel" class="btn btn-danger">Удалить</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                department: null,
                previous_name: null,
                sending: false
            }
        },
        methods: {
            updateModel() {
                if (this.department.name.length <= 3) {
                    this.$messenger("Слишком короткое название!", true);
                    return;
                }
                if (this.sending) {
                    return;
                }
                this.sending = true;
                axios.post('/departments/edit', {
                    id: this.department.id,
                    name: this.department.name
                })
                    .then(response => {
                        this.sending = false;
                        this.$messenger(response.data.msg, response.data.error);
                        if (!response.data.error) {
                            this.previous_name = this.department.name;
                        }
                    })
                    .catch(error => {
                        this.$messenger("Не удалось выполнить запрос. Ошибка: " + error.message, true);
                        this.sending = false;
                    })
            },
            resetModel() {
                this.department.name = this.previous_name;
            },
            deleteModel() {
                if (confirm(`Вы действительно хотите удалить ${this.department.name} из базы?`)) {
                    if (this.sending) {
                        return;
                    }
                    this.sending = true;
                    axios.post('/departments/delete', {
                        id: this.department.id,
                    })
                        .then(response => {
                            this.sending = false;
                            this.$messenger(response.data.msg, response.data.error);
                            if (!response.data.error) {
                                this.$router.push(response.data.redirect);
                            }
                        })
                        .catch(error => {
                            this.$messenger("Не удалось выполнить запрос. Ошибка: " + error.message, true);
                            this.sending = false;
                        })
                }
            }
        },
        created() {
          this.$root.$on("dataFetched", data => {
             this.department = data;
             this.previous_name = data.name;
          });
        }
    }
</script>