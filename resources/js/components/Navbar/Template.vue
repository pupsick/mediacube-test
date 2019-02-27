<template>
    <nav class="navbar navbar-expand-lg navbar-light navbar-dark bg-dark fixed-top">
        <router-link to="/" class="navbar-brand">MediaCube test</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <nav-item v-for="(item, key) in navItems" v-bind="{item}" :key="key"></nav-item>
            </ul>
        </div>
    </nav>
</template>

<script>
    import NavItem from './Item';
    export default {
        data() {
            return {
                navItems: [
                    { title: 'Сетка', component: 'Home' },
                    { title: 'Сотрудники', component: 'Employees' },
                    { title: 'Отделы', component: 'Departments' },
                ]
            }
        },
        components: {
            NavItem
        }
    }
</script>