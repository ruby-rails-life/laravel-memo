<template>
    <div>
        <p>
            <router-link class="btn btn-outline-primary" :to="{name: 'book-create'}">書籍作成</router-link>
        </p>
        <div class="table-responsive table-area">
            <table class="table table-striped table-sm text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Summary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(book, index) in books" v-bind:key="book.id">
                        <td>{{book.id}}</td>
                        <td>{{book.title}}</td>
                        <td>{{book.summary}}</td>
                    </tr>
                </tbody>
            </table>    
        </div>
    </div>    
</template>


<script>
    export default {
        data: function () {
            return {
                books: []
            }
        },
        methods: {
            fetchBooks: function(){
                axios.get('/api/books').then((res)=>{
                    this.books = res.data
                });
            }
        },
        created(){
            this.fetchBooks();
        }
    }
</script>