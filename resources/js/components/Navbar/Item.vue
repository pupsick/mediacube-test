<template>
    <li class="nav-item" v-bind:class="{active: this.$route.name === this.item.component}">
        <router-link :to="{name: this.item.component}" class="nav-link">{{this.item.title}}</router-link>
    </li>
</template>

<script>
    export default {
        props: ['item']
    }
</script>