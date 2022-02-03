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
                        <th>Тип документа</th>
                        <th>Подписан</th>
                        <th></th>
                    </tr>
                    <tr class="document mb-3" v-for="(document, index) in documents">
                        <td>
                            <input class="form-control" v-bind:class="{'is-invalid': !document.name || document.name === ''}" type="text" v-model="document.name">
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
                        <td>
                            <button v-on:click="showDeletePopup(document.id)" class="btn btn-outline-danger">x</button>
                        </td>
                    </tr>
                </table>

                <button v-on:click="addDocument" class="btn btn-primary mb-5" type="button">Добавить документ</button>

                <button type="submit" class="btn btn-primary mb-5">Сохранить</button>
            </form>
        </div>
        <div class="modal" v-bind:class="{ active: isShowDeletePopup === true}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Подтвердите удаление</h5>
                        <button @click="isShowDeletePopup = false" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <p>Файл удалится безвозвратно</p>
                        <button @click="isShowDeletePopup = false" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button @click="deleteDocument" type="button" class="btn btn-primary">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop" v-bind:class="{ show: isShowDeletePopup === true}" @click="isShowDeletePopup = false"></div>
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

            for(var index in th.documents) {
                if(!th.documents[index].name || th.documents[index].name === '')
                    return
                if (th.documents[index].file && th.documents[index].file !== '')
                    documents.push(th.documents[index])
            }

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
        showDeletePopup(item, index) {
            if(item.file) {
                this.isShowDeletePopup = true
                this.itemForDeleting = item.id
                this.itemIndexDeleting = index
            } else {
                this.documents.splice(index, 1)
            }
        },
        deleteDocument() {
            axios.delete('/api/documents/' + this.itemForDeleting).then(response => {
                this.isShowDeletePopup = false
                this.documents.splice(this.itemIndexDeleting, 1)
            })
        },
    }
}
</script>
