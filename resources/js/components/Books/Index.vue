<template>
    <div>
        <p>
            <router-link class="btn btn-outline-primary rounded-circle p-0 circle-css text-center" :to="{name: 'book-create'}">+</router-link>
        </p>
        <div class="table-responsive table-area">
            <table class="table table-striped table-sm text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Summary</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(book, index) in books" v-bind:key="book.id">
                        <td>{{book.id}}</td>
                        <td>{{book.title}}</td>
                        <td>{{book.summary}}</td>
                        <td>
                            <router-link class="btn btn-info" :to="{name: 'book-show', params: {id: book.id}}">Show</router-link>
                            <router-link class="btn btn-success" :to="{name: 'book-edit', params: {id: book.id}}">Edit</router-link>
                            <button v-on:click="deleteBook(book.id)" class="btn btn-warning">Delete</button>
                        </td>                
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
            },
            deleteBook: function(id){
                let uri = '/api/books/' + id;
                axios.delete(uri, this.book).then(res => {
                    location.reload();
                });
            }
        },
        created(){
            this.fetchBooks();
        }
    }
</script>

<style>
    .circle-css {
        width:2rem;
        height:2rem;
    }
</style>