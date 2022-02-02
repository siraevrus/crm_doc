<template>
    <div class="restaurant_add">
        <h3>Редактирование клиента</h3>

        <div class="col-lg-6">
            <form @submit.prevent="onSubmit">
                <div class="mb-3">
                    <input type="text" class="form-control" v-bind:class="{'is-invalid': errors.name}" v-model="name" id="name" placeholder="Название">
                </div>

                <table class="documents mt-3 mb-3">
                    <tr>
                        <th>Название</th>
                        <th>Документ</th>
                        <th>Подписан</th>
                        <th></th>
                    </tr>
                    <tr class="document mb-3" v-for="(document, index) in documents">
                        <td>
                            <input type="text" v-model="document.name">
                        </td>
                        <td>
                            <input v-if="document.file === ''" type="file" name="document" @change.prevent="upload($event, index)">
                            <a v-else :href="document.file" target="_blank">Документ</a>
                        </td>
                        <td>
                            <select v-model="document.type">
                                <option value="contract">Договор</option>
                                <option value="act">Акт</option>
                                <option value="bill">Счет</option>
                            </select>
                        </td>
                        <td>
                            <input type="checkbox" v-model="document.signed">
                        </td>
                    </tr>
                </table>

                <button v-on:click="addDocument" class="btn btn-primary mb-5" type="button">Добавить документ</button>

                <button type="submit" class="btn btn-primary mb-5">Сохранить</button>
            </form>
        </div>
    </div>
</template>
<script>
import add from './ClientsAdd'

export default {
    props: ['client'],
    mixins: [add],
    mounted() {
        this.load()
    },
    methods: {
        load(){
            axios.get('/api/clients/' + this.client).then(response => {
                this.name = response.data.data.name
                this.documents = response.data.data.documents
            })
        },
        onSubmit() {
            var th = this
            var documents = []
            for (var error in th.errors) {
                th.errors[error] = false
            }

            for(var index in th.documents)
                if(th.documents[index].file && th.documents[index].file !== '')
                    documents.push(th.documents[index])

            axios.put('/api/clients/' + this.client, {
                name: th.name,
                documents: documents
            }).then(data => {
                document.location.href = '/'
            }).catch(error => {
                if (error.response.status == 422) {
                    for(var er in error.response.data.errors)
                        if(er in th.errors)
                            th.errors[er] = true
                }
                else
                    alert("Что-то пошло не так")
            })
        },
    }
}
</script>
