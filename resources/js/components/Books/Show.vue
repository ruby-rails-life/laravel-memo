<template>
    <div>
        <div class="row">
            <div class="col-md-2">Title</div>
            <div class="col-md-10">{{book.title}}</div>
        </div>
        <div class="row">
            <div class="col-md-2">Summary</div>
            <div class="col-md-10">{{book.summary}}</div>
        </div>
        <div class="row mt-2">
            <div class="offset-md-2 col-md-10">
                <router-link class="btn btn-primary rounded-pill" :to="{name: 'book-list'}">一覧に戻る</router-link>
                <router-link class="btn btn-primary rounded-pill" :to="{name: 'book-edit', params: {id: book.id}}">編集</router-link>
            </div>
        </div>    
    </div>  
</template>

<script>
    export default {
        data: function () {
            return {
                book: {
                    title:'',
                    summary:''
                }
            }
        },
        methods: {
            showBook: function(){
                let uri = '/api/books/' + this.$route.params.id;
                axios.get(uri).then((res)=>{
                    this.book = res.data
                });
            }
        },
        created(){
            this.showBook();
        }
    }
</script>