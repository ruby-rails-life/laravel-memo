<!doctype html>
  <html lang="{{ app()->getLocale() }}">
    <head>
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="{{ asset('css/app.css') }}">
      <title>Laravel-Vue-todo</title>
    </head>
    <body>
      <div id="app">
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
                        <td>@{{todo.id}}</td>
                        <td>@{{todo.title}}</td>
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
      </div>
      <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>