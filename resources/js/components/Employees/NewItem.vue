<template>
    <div>
        <h1>Добавление сотрудника</h1>
        <form class="my-5">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Имя <span class="red">*</span></label>
                <div class="col-sm-5">
                    <input type="text" v-model="model.name" class="form-control" placeholder="Имя сотрудника">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Фамилия <span class="red">*</span></label>
                <div class="col-sm-5">
                    <input type="text" v-model="model.surname" class="form-control" placeholder="Фамилия сотрудника">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Отчество</label>
                <div class="col-sm-5">
                    <input type="text" v-model="model.patronymic" class="form-control"
                           placeholder="Отчество сотрудника">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Пол</label>
                <div class="col-sm-5">
                    <select v-model="model.gender">
                        <option value="0">М</option>
                        <option value="1">Ж</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Заработная плата</label>
                <div class="col-sm-5">
                    <input type="number" v-model="model.salary" class="form-control"
                           placeholder="Заработная плата сотрудника">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Отделы <span class="red">*</span></label>
                <div class="col-sm-5">
                    <div class="form-check-inline" v-for="department in departments">
                        <input class="form-check-input" v-model="model.departments" type="checkbox"
                               :value="department.id">
                        <label class="form-check-label">
                            {{department.name}}
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-controls mt-4">
                <button :disabled="departments.length == 0" type="submit" @click.prevent="createModel" class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                model: {
                    name: "",
                    surname: "",
                    patronymic: "",
                    gender: 0,
                    salary: 0,
                    departments: []
                },
                departments: "",
                sending: false,
            }
        },
        methods: {
            createModel() {
                if (this.model.departments.length == 0) {
                    this.$messenger("Необходимо выбрать хотя бы один отдел", true);
                    return;
                }
                if (this.model.name.length <= 1) {
                    this.$messenger("Веденное имя слишком короткое", true);
                    return;
                }

                if (this.model.surname.length <= 0) {
                    this.$messenger("Введенная фамилия слишком короткая", true);
                    return;
                }

                if (this.sending) {
                    return;
                }

                this.sending = true;
                axios.post('/employees/add', this.model)
                    .then(response => {
                        this.sending = false;
                        this.$messenger(response.data.msg, response.data.error);
                        if (response.data.error) {
                            return;
                        } else {
                            this.$router.push(response.data.redirect);
                        }
                    })
                    .catch(error => {
                        this.$messenger("Не удалось выполнить запрос. Ошибка: " + error.message, true);
                        this.sending = false;
                    })
            },
        },
        created() {
            this.$root.$on("dataFetched", data => {
                this.departments = data;
            });
        }
    }
</script>