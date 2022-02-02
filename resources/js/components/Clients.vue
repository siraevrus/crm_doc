<template>
    <div class="clients mt-5">
        <h3>Клиенты</h3>
        <div class="d-flex justify-content-between mb-5">
            <form @submit.prevent="list">
                <input type="text" v-model="filter" placeholder="Поиск по названию"/>
                <button type="submit">Найти</button>
            </form>

            <div class="doc-type-filter d-flex">
                <a href="" v-for="(item, index) in doc_types" @click.prevent="setDocType(item.value)" v-bind:class="{active: item.value == doc_type}">
                    <div v-if="index > 0">/</div>{{item.name}}
                </a>
            </div>

            <button @click="toAdding()">Новый клиент</button>
        </div>
        <table class="mb-5">
            <tr>
                <th>Организация</th>
                <th>Название документа</th>
                <th>Тип документа</th>
                <th>Cтатус</th>
                <th></th>
                <th></th>
            </tr>
            <tr :rowspan="item.documents.length > 1 ? item.documents.length : 1" v-for="item in items">
                <td>{{item.name}}</td>
                <td>
                    <span v-for="doc in item.documents">
                        <a target="_blank" :href="doc.file">
                            <div v-if="doc.name && doc.name !== ''">{{doc.name}}</div>
                            <div v-else>Без имени</div>
                        </a>
                    </span>
                </td>
                <td>
                    <span v-for="doc in item.documents">
                        {{showType(doc.type)}}
                        <br>
                    </span>
                </td>
                <td>
                    <span v-for="doc in item.documents">
                        <div class="sign signed" v-if="doc.signed">Подписан</div>
                        <div class="sign" v-else>Не подписан</div>
                    </span>
                </td>
                <td v-on:click="toUpdate(item.id)" class="manage">ред</td>
                <td v-on:click="showDeletePopup(item.id)" class="manage">удалить</td>
            </tr>
        </table>

        <ul class="pagination">
            <li v-for="item in pages" v-bind:class="{ active: item === page}"><a @click.prevent="changePage(item)" href="">{{item}}</a></li>
        </ul>

        <div class="modal" v-bind:class="{ active: isShowDeletePopup === true}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Подтвердите удаление</h5>
                        <button @click="isShowDeletePopup = false" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <button @click="isShowDeletePopup = false" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                        <button @click="deleteClient" type="button" class="btn btn-primary">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop" v-bind:class="{ show: isShowDeletePopup === true}" @click="isShowDeletePopup = false"></div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            per_page: 10,
            page: 1,
            pages: 0,
            filter: "",
            doc_type: "",
            doc_types: [
                {
                    name: 'Все',
                    value: ''
                },
                {
                    name: 'Договор',
                    value: 'contract'
                },
                {
                    name: 'Акт',
                    value: 'act'
                },
                {
                    name: 'Счет',
                    value: 'bill'
                }
            ],
            isShowDeletePopup: false,
            itemForDeleting: 0,
            items: []
        }
    },
    mounted() {
        this.list()
    },
    methods: {
        list() {
            var th = this
            var filter = ""
            if(this.filter !== "") {
                filter = "filter[0][field]=name"
                    + "&filter[0][operator]=ilike"
                    + "&filter[0][value]=" + this.filter
            }
            if(this.doc_type !== "") {
                var i = 0
                if(filter !== '') {
                    i = 1
                    filter += '&'
                }
                filter += "filter["+i+"][field]=documents.type"
                    + "&filter["+i+"][operator]=="
                    + "&filter["+i+"][value]=" + this.doc_type
            }

            axios.get('/api/clients/?page=' + this.page + "&" + filter).then(response => {
                for(var index in response.data.data) {
                    th.items.push(response.data.data[index])
                    if(th.doc_type !== "") {
                        var docs = []
                        for(var i in th.items[th.items.length - 1].documents) {
                            if (th.items[th.items.length - 1].documents[i].type === th.doc_type)
                                docs.push(th.items[th.items.length - 1].documents[i])
                        }

                        th.items[th.items.length - 1].documents = docs
                    }
                }

                this.items = response.data.data
                this.total = response.data.total
                this.pages = Math.ceil(this.total / this.per_page)
            })
        },
        toAdding() {
            document.location.href = '/add'
        },
        toUpdate(id) {
            document.location.href = '/'+id
        },
        showType(type) {
            switch (type) {
                case "contract":
                    return "Договор"
                case "act":
                    return "Акт"
                case "bill":
                    return "Счет"
            }
        },
        deleteClient() {
            axios.delete('/api/clients/' + this.itemForDeleting).then(response => {
                this.list()
                this.isShowDeletePopup = false
            })
        },
        changePage(page) {
            this.page = page
            this.list()
        },
        showDeletePopup(id) {
            this.isShowDeletePopup = true
            this.itemForDeleting = id
        },
        setDocType(type) {
            this.doc_type = type
            this.list()
        }
    }
}
</script>
