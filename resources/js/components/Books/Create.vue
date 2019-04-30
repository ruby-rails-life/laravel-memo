<template>
    <div>
        <h4>書籍作成</h4>
        <div class="form-group row">
            <label for="txtTitle" class="col-md-2 col-form-label">Title</label>
            <div class="col-md-10">
                <input v-model="title" type="text" class="form-control" id="txtTitle" placeholder="title">
            </div>
        </div>
        <div class="form-group row">
            <label for="txtSummary" class="col-md-2 col-form-label">Summary</label>
            <div class="col-md-10">
                <textarea id="txtSummary" v-model="summary" class="form-control" rows="4" placeholder="summary"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-md-2 col-md-10">
                <button v-on:click="addBook" class="btn btn-primary">登録</button>
                <a href="/books/" class="btn btn-secondary">キャンセル</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // コンポーネント作成時に実行する処理を定義
        // created() {
        // 今回は特に処理はありません
        // },

        // テンプレート内で使う変数を定義
        data() {
            return {
                title:'',
                summary:''
            }
        },
        // メソッドの定義。ここでv-on:click=''で記述したpostBook()メソッドを定義します
        methods: {
            addBook(){
                // テンプレートのv-modelのtitleとsummaryの入力値を取得しbookという配列に格納
                var book = {
                    'title': this.title,
                    'summary': this.summary
                };

                // axios.postの第１引数にルートを、第２引数にポストするデータの配列を渡します
                axios.post('/api/books', book).then(res => {

                    // テストのため返り値をコンソールに表示
                    alert(res.data.title);
                    alert(res.data.summary);
                });
            }

        }
    }
</script>