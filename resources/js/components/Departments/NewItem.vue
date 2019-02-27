<template>
    <div>
        <h1>Добавление нового отдела</h1>
        <form class="my-5">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Название <span class="red">*</span></label>
                <div class="col-sm-5">
                    <input aria-required="true" type="text" v-model="name" class="form-control" placeholder="Название отдела">
                </div>
            </div>
            <div class="form-controls mt-4">
                <button :disabled="sending" type="submit" @click.prevent="createModel" autofocus class="btn btn-primary">Добавить</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: "",
                sending: false
            }
        },
        methods: {
            createModel() {
                if (this.name.length <= 3) {
                    this.$messenger("Слишком короткое название!", true);
                    return;
                }
                if (this.sending) {
                    return;
                }
                this.sending = true;
                axios.post('/departments/add', {
                    name: this.name
                })
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
        }
    }
</script>