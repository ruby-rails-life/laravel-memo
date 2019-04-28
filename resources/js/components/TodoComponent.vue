<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-sm-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>タスク名</th>
                            <th>完了ボタン</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="todo in todos" v-bind:key="todo.id">
                            <td>{{todo.id}}</td>
                            <td>{{todo.title}}</td>
                            <td><button class="btn btn-secondary" v-on:click="deleteTodo(todo.id)">完了</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="タスクを入力してください" v-model="new_todo">
                    <span class="input-group-btn">
                        <button class="btn btn-success" type="button" v-on:click="addTodo">タスクを登録</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                todos: [],
                new_todo: ''
            }
        },
        methods: {
            fetchTodos: function(){
                axios.get('/api/get').then((res)=>{
                    this.todos = res.data
                });
            },
            addTodo: function(){
                axios.post('/api/add',{
                    title: this.new_todo
                }).then((res)=>{
                    this.todos = res.data;
                    this.new_todo = '';
                }).catch(error => {
                    alert(error.response)
                });
            },
            deleteTodo: function(task_id){
                axios.post('/api/del',{
                    id: task_id
                }).then((res)=>{
                    this.todos = res.data
                })
            }
        },
        created(){
            this.fetchTodos();
        }
    }
</script>