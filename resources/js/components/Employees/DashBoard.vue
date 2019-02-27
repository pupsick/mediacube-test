<template>
    <div>
        <h1 class="mb-4">Управление сотрудниками</h1>
        <employee-table></employee-table>
    </div>
</template>

<script>
    import EmployeeTable from "./Table";
    export default {
        components: {
            EmployeeTable
        }
    }
</script>