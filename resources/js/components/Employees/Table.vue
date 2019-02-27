<template>
    <div>
        <div class="form-controls my-4">
            <router-link :to="{name: 'EmployeeAdd'}" class="btn btn-primary">Добавить</router-link>
        </div>
        <table class="table employees">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
                <th>Пол</th>
                <th>Заработная плата</th>
                <th>Отделы</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in employees">
                <td>{{parseName(employee.name, 0)}}</td>
                <td>{{parseName(employee.name, 1)}}</td>
                <td>{{parseName(employee.name, 2)}}</td>
                <td>{{genders[employee.gender]}}</td>
                <td>{{employee.salary}}$</td>
                <td>{{employee.departments_concat}}</td>
                <td>
                    <router-link :to="{name: 'EmployeeItem', params: {id: employee.id}}" class="item-controls">
                        <i class="material-icons yellow">edit</i>
                    </router-link>
                    <a class="item-controls" href="/" @click.prevent="deleteEmployee(employee)"><i
                            class="material-icons red">delete</i></a>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="form-controls float-right">
            <span class="float-right">Страница {{currentPage}} из {{maxPage}}</span>
            <br />
            <button class="btn btn-primary mt-3" @click.prevent="GotoPrevPage()" v-if="prevPage">Предыдущая</button>
            <button class="btn btn-primary mt-3" @click.prevent="GotoNextPage()" v-if="nextPage">Следующая</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                employees: [],
                genders: [
                    'М', 'Ж'
                ],
                prevPage: false,
                nextPage: false,
                currentPage: 1,
                maxPage: 1
            }
        },
        methods: {
            deleteEmployee(item) {
                if (confirm(`Вы действительно хотите удалить ${item.name} из базы?`)) {
                    axios.post('/employees/delete', {
                        id: item.id,
                    })
                        .then(response => {
                            this.sending = false;
                            this.$messenger(response.data.msg, response.data.error);
                            if (!response.data.error) {
                                this.employees = this.employees.filter(employee => {
                                    return employee.id !== item.id;
                                });
                            }
                        })
                        .catch(error => {
                            this.$messenger("Не удалось выполнить запрос. Ошибка: " + error.message, true);
                            this.sending = false;
                        })
                }
            },
            getData() {
                this.employees = [];
                axios.get('/employees/page/' + this.currentPage)
                    .then(response => {
                        this.parseData(response.data);
                    })
                    .catch(error => {
                        this.$messenger("Не удалось выполнить запрос. Ошибка: " + error.message, true);
                        this.sending = false;
                    })
            },
            GotoPrevPage() {
                this.currentPage--;
                this.getData();
            },
            GotoNextPage() {
                this.currentPage++;
                this.getData();
            },
            parseName(name, index) {
                return name.split(" ")[index];
            },
            parseData(data) {
                this.employees = data.data;
                this.nextPage = !!data.next_page_url;
                this.prevPage = !!data.prev_page_url;
                this.currentPage = data.current_page;
                this.maxPage = data.last_page;
            }
        },
        created() {
            this.$root.$on("dataFetched", data => {
               this.parseData(data);
            });
        }
    }
</script>