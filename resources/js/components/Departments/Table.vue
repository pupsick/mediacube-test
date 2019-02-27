<template>
    <div>
        <div class="form-controls my-4">
            <router-link :to="{name: 'DepartmentAdd'}" class="btn btn-primary">Добавить</router-link>
        </div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Название отдела</th>
                <th>Количество сотрудников</th>
                <th>Максимальная зарплата</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="department in departments">
                <td>{{department.name}}</td>
                <td>{{department.employees_count}}</td>
                <td>{{department.max_salary}}$</td>
                <td>
                    <router-link :to="{name: 'DepartmentItem', params: {id: department.id}}" class="item-controls">
                        <i class="material-icons yellow">edit</i>
                    </router-link>
                    <a class="item-controls" href="#" @click.prevent="deleteDepartment(department)"><i
                            class="material-icons red">delete</i></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                departments: [],
            }
        },
        methods: {
            deleteDepartment(item) {
                if (confirm(`Вы действительно хотите удалить ${item.name} из базы?`)) {
                    axios.post('/departments/delete', {
                        id: item.id,
                    })
                        .then(response => {
                            this.sending = false;
                            this.$messenger(response.data.msg, response.data.error);
                            if (!response.data.error) {
                                this.departments = this.departments.filter(department => {
                                    return department.id !== item.id;
                                });
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
                this.departments = data;
            })
        }
    }
</script>