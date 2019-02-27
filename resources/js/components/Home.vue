<template>
    <div>
        <h1 class="mb-4">Список сотрудников</h1>
        <relation-table></relation-table>
    </div>
</template>

<script>
    import RelationTable from './Table/Table';
    export default {
        components: {
            RelationTable
        }
    }
</script>