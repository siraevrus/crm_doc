<template>
    <div class="restaurant_add">
        <h3>Добавление клиента</h3>

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
                            <a v-else :href="document.file.name" target="_blank">Документ</a>
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

                <button type="submit" class="btn btn-primary mb-5">Добавить клиента</button>
            </form>
        </div>
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    components: {
        vueDropzone: vue2Dropzone
    },
    data() {
        return {
            name: "",
            documents: [],
            dropzoneOptions: {
                url: '/api/files/',
                thumbnailWidth: 150,
                addRemoveLinks: true,
                maxFilesize: 0.5,
                headers: { "My-Awesome-Header": "header value" }
            },
            errors: {
                name: false,
            }
        }
    },
    mounted() {
    },
    computed: {
        selector() {
            return `dropzone`
        }
    },
    methods: {
        onSubmit() {
            var th = this
            var documents = []
            for (var error in th.errors) {
                th.errors[error] = false
            }

            for(var index in th.documents)
                if(th.documents[index].file && th.documents[index].file !== '')
                    documents.push(th.documents[index])

            axios.post('/api/clients/', {
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
        addDocument() {
            this.documents.push({
                name: "",
                file: "",
                signed: false
            });
        },
        upload: function(e, index) {
            var th = this
            var data = new FormData()
            data.append('document', e.target.files[0])

            if(this.documents[index].file) {
                axios({
                    method: "put",
                    url: "/api/documents/" + this.documents[index].id,
                    data: data,
                    headers: { "Content-Type": "multipart/form-data" },
                })
                    .then(function (response) {
                        th.documents[index].id = response.data.data.id
                        th.documents[index].file = response.data.data.file
                    })
                    .catch(function (response) {
                        console.log(response)
                    })
            } else {
                axios({
                    method: "post",
                    url: "/api/documents",
                    data: data,
                    headers: { "Content-Type": "multipart/form-data" },
                })
                    .then(function (response) {
                        th.documents[index].id = response.data.data.id
                        th.documents[index].file = response.data.data.file
                    })
                    .catch(function (response) {
                        console.log(response)
                    })
            }
        }
    }
}
</script>
