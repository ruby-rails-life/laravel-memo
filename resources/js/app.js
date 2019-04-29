
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('todo-component', require('./components/TodoComponent.vue').default);
// Vue.component('invoice-component', require('./components/InvoiceComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//const app = new Vue({
    //el: '#app'
    // el: '#app',
    // data: {
    //     todos: [],
    //     new_todo: ''
    // },
    // methods: {
    //     fetchTodos: function(){
    //         axios.get('/api/get').then((res)=>{
    //             this.todos = res.data
    //         });
    //     },
    //     addTodo: function(){
    //         axios.post('/api/add',{
    //             title: this.new_todo
    //         }).then((res)=>{
    //             this.todos = res.data;
    //             this.new_todo = '';
    //         }).catch(error => {
    //             alert(error.response)
    //         });
    //     },
    //     deleteTodo: function(task_id){
    //         axios.post('/api/del',{
    //             id: task_id
    //         }).then((res)=>{
    //             this.todos = res.data
    //         })
    //     }
    // },
    // created(){
    //     this.fetchTodos();
    // }
//});

var app = new Vue({
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
