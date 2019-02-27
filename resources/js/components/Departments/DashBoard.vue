<template>
    <div>
        <h1 class="mb-4">Управление отделами</h1>
        <departments-table></departments-table>
    </div>
</template>

<script>
    import DepartmentsTable from "./Table";
    export default {
        components: {
            DepartmentsTable
        }
    }
</script>