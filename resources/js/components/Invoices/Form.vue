<template>
    <div>
        <div class="panel panel-default" v-cloak>
            <div class="panel-heading">
                <div class="clearfix">
                    <span class="panel-title">Create Invoice</span>
                    <a href="/invoices" class="btn btn-default pull-right">Back</a>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Invoice No.</label>
                            <input type="text" class="form-control" v-model="form.invoice_no">
                            <p v-if="errors.invoice_no" class="text-danger">{{errors.invoice_no[0]}}</p>
                        </div>
                        <div class="form-group">
                            <label>Client</label>
                            <input type="text" class="form-control" v-model="form.client">
                            <p v-if="errors.client" class="text-danger">{{errors.client[0]}}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Client Address</label>
                            <textarea class="form-control" v-model="form.client_address"></textarea>
                            <p v-if="errors.client_address" class="text-danger">{{errors.client_address[0]}}</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" v-model="form.title">
                            <p v-if="errors.title" class="text-danger">{{errors.title[0]}}</p>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Invoice Date</label>
                                <input type="date" class="form-control" v-model="form.invoice_date">
                                <p v-if="errors.invoice_date" class="text-danger">{{errors.invoice_date[0]}}</p>
                            </div>
                            <div class="col-sm-6">
                                <label>Due Date</label>
                                <input type="date" class="form-control" v-model="form.due_date">
                                <p v-if="errors.due_date" class="text-danger">{{errors.due_date[0]}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div v-if="errors.products_empty">
                    <p class="alert alert-danger">{{errors.products_empty[0]}}</p>
                    <hr>
                </div>
                <table class="table table-bordered table-form">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product, index) in form.products">
                            <td class="table-name" :class="{'table-error': errors['products.' + index  + '.name']}">
                                <textarea class="table-control" v-model="product.name"></textarea>
                            </td>
                            <td class="table-price" :class="{'table-error': errors['products.' + index + '.price']}">
                                <input type="text" class="table-control"  v-model="product.price">
                            </td>
                            <td class="table-qty" :class="{'table-error': errors['products.' + index + '.qty']}">
                                <input type="text" class="table-control" v-model="product.qty">
                            </td>
                            <td class="table-total">
                                <span class="table-text">{{product.qty * product.price}}</span>
                            </td>
                            <td class="table-remove">
                                <span @click="remove(index)" class="table-remove-btn">&times;</span>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="table-empty" colspan="2">
                                <span @click="addLine" class="table-add_line">Add Line</span>
                            </td>
                            <td class="table-label">Sub Total</td>
                            <td class="table-amount">{{subTotal}}</td>
                        </tr>
                        <tr>
                            <td class="table-empty" colspan="2"></td>
                            <td class="table-label">Discount</td>
                            <td class="table-discount" :class="{'table-error': errors.discount}">
                                <input type="text" class="table-discount_input" v-model="form.discount">
                            </td>
                        </tr>
                        <tr>
                            <td class="table-empty" colspan="2"></td>
                            <td class="table-label">Grand Total</td>
                            <td class="table-amount">{{grandTotal}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="panel-footer">
                <a href="/invoices" class="btn btn-default">CANCEL</a>
                <button v-if="form.id" class="btn btn-success" @click="update" :disabled="isProcessing">UPDATE</button>
                <button v-else="form.id" class="btn btn-success" @click="create" :disabled="isProcessing">CREATE</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['pform'],
        data() {
            return {
                isProcessing: false,
                form: {},
                errors: {}
            }
        },
        created: function () {
            this.form = this.pform;
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
                .then(response => {
                    if(response.data.created) {
                        window.location = '/invoices/' + response.data.id;
                    } else {
                        this.isProcessing = false;
                    }
                })
                .catch(e => {
                    this.isProcessing = false;
                    this.errors = e.response.data.errors;
                });
        },
        update: function() {
            this.isProcessing = true;
            axios.put('/invoices/' + this.form.id, this.form)
                .then(response => {
                    if(response.data.updated) {
                        window.location = '/invoices/' + response.data.id;
                    } else {
                        this.isProcessing = false;
                    }
                })
                .catch(e => {
                    this.isProcessing = false;
                    this.errors = e.response.data.errors;
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
    }
</script>

<style>
    .table-error {
        border-color: red !important;
    }
</style>