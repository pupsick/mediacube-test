<template>
    <div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Сотрудник</th>
                <th v-for="department in departments" scope="col">{{department.name}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="employee in employees">
                <th scope="row">{{employee.name}}</th>
                <td v-for="department in departments">
                    <i class="material-icons green" v-if="employee.departments_id.indexOf(department.id) > -1">done</i>
                    <i class="material-icons red" v-else>clear</i>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="form-controls float-right">
            <span class="float-right">Страница {{currentPage}} из {{maxPage}}</span>
            <br/>
            <button class="btn btn-primary mt-3" @click.prevent="GotoPrevPage" v-if="prevPage">Предыдущая</button>
            <button class="btn btn-primary mt-3" @click.prevent="GotoNextPage" v-if="nextPage">Следующая</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                departments: [],
                employees: [],
                prevPage: false,
                nextPage: false,
                currentPage: 1,
                maxPage: 1
            }
        },
        created() {
            this.$root.$on("dataFetched", data => {
                this.departments = data.departments;
                this.parseData(data.employees);
            });
        },
        methods: {
            getData() {
                this.employees = [];
                axios.get('/table/page/' + this.currentPage)
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
            parseData(data) {
                this.employees = data.data;
                this.nextPage = !!data.next_page_url;
                this.prevPage = !!data.prev_page_url;
                this.currentPage = data.current_page;
                this.maxPage = data.last_page;
            }
        }
    }

</script>