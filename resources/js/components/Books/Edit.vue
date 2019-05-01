<template>
    <div>
        <h4>書籍編集</h4>
        <div class="form-group row">
            <label for="txtTitle" class="col-md-2 col-form-label">Title</label>
            <div class="col-md-10">
                <input id="txtTitle" v-model="book.title" type="text" class="form-control" placeholder="title">
            </div>
        </div>
        <div class="form-group row">
            <label for="txtSummary" class="col-md-2 col-form-label">Summary</label>
            <div class="col-md-10">
                <textarea id="txtSummary" v-model="book.summary" class="form-control" rows="4" placeholder="summary"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-md-2 col-md-10">
                <button v-on:click="updateBook" class="btn btn-primary rounded-pill">更新</button>
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
                    id:'',
                    title:'',
                    summary:''
                }
            }
        },
        methods: {
            updateBook(){
                let uri = '/api/books/' + this.$route.params.id;
                axios.put(uri, this.book).then(res => {
                    this.$router.push({name: 'book-list'});
                });
            },
            editBook: function(){
                let uri = '/api/books/' + this.$route.params.id + '/edit';
                axios.get(uri).then((res)=>{
                    this.book = res.data
                });
            }
        },
        created(){
            this.editBook();
        }
    }
</script>