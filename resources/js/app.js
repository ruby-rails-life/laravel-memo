// bootstrap.jsのrequire
require('./bootstrap');

// vueとvue-routerの定義
import Vue from 'vue'

// Vue-Router
import router from './router'

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('todo-component', require('./components/TodoComponent.vue').default);

const app = new Vue({
    el: '#app',
    router,
});

// const app = new Vue({
//     el: '#app',
//     data: {
//         todos: [],
//         new_todo: ''
//     },
//     methods: {
//         fetchTodos: function(){
//             axios.get('/api/get').then((res)=>{
//                 this.todos = res.data
//             });
//         },
//         addTodo: function(){
//             axios.post('/api/add',{
//                 title: this.new_todo
//             }).then((res)=>{
//                 this.todos = res.data;
//                 this.new_todo = '';
//             }).catch(error => {
//                 alert(error.response)
//             });
//         },
//         deleteTodo: function(task_id){
//             axios.post('/api/del',{
//                 id: task_id
//             }).then((res)=>{
//                 this.todos = res.data
//             })
//         }
//     },
//     created(){
//         this.fetchTodos();
//     }
// });

var invoice = new Vue({
  el: '#invoice',
  data: {
    isProcessing: false,
    form: {},
    errors: {}
  },
  created: function () {
    Vue.set(this.$data, 'form', _form);
  },
  methods: {
    addLine: function() {
      this.form.products.push({name: '', price: 0, qty: 1});
    },
    remove: function(index) {
      this.form.products.splice(index,1);
    },
    create: function() {
      this.isProcessing = true;
      axios.post('/invoices', this.form)
        .then(function(response) {
          if(response.data.created) {
            window.location = '/invoices/' + response.data.id;
          } else {
            this.isProcessing = false;
          }
        })
        .catch(function(response) {
          this.isProcessing = false;
          Vue.set(this.$data, 'errors', response.data);
        })
    },
    update: function() {
      this.isProcessing = true;
      axios.put('/invoices/' + this.form.id, this.form)
        .then(function(response) {
          if(response.data.updated) {
            window.location = '/invoices/' + response.data.id;
          } else {
            this.isProcessing = false;
          }
        })
        .catch(function(response) {
          this.isProcessing = false;
          Vue.set(this.$data, 'errors', response.data);
        })
    }
  },
  computed: {
    subTotal: function() {
      return this.form.products.reduce(function(carry, product) {
        return carry + (parseFloat(product.qty) * parseFloat(product.price));
      }, 0);
    },
    grandTotal: function() {
      return this.subTotal - parseFloat(this.form.discount);
    }
  }
})