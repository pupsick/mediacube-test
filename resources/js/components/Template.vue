<template>
    <div>
        <navbar></navbar>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Navbar from "./Navbar/Template";

    export default {
        components: {
            Navbar
        },
    }
</script>