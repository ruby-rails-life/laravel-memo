<template>
    <div>
        <h4>書籍作成</h4>
        <div class="form-group row">
            <label for="txtTitle" class="col-md-2 col-form-label">Title</label>
            <div class="col-md-10">
                <input id="txtTitle" v-model="book.title" type="text" class="form-control" placeholder="title">
                <p v-if="errors.title" class="text-danger">{{errors.title[0]}}</p>
            </div>
        </div>
        <div class="form-group row">
            <label for="txtSummary" class="col-md-2 col-form-label">Summary</label>
            <div class="col-md-10">
                <textarea id="txtSummary" v-model="book.summary" class="form-control" rows="4" placeholder="summary"></textarea>
                <p v-if="errors.summary" class="text-danger">{{errors.summary[0]}}</p>
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-md-2 col-md-10">
                <button v-on:click="addBook" class="btn btn-primary rounded-pill">登録</button>
                <router-link class="btn btn-secondary rounded-pill" :to="{name: 'book-list'}">キャンセル</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                book: {
                    title:'',
                    summary:''
                },
                errors: {}
            }
        },
        methods: {
            addBook(){
                // axios.postの第１引数にルートを、第２引数にポストするデータの配列を渡します
                axios.post('/api/books', this.book)
                    .then(res => {
                        this.$router.push({name: 'book-list'});
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                    });
            }
        }
    }
</script>