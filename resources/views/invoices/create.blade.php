@extends('layouts.invoice')

@section('content')
    <div id="app">
        <invoice-form v-bind:pform="{invoice_no: '',
            client: '',
            client_address: '',
            title: '',
            invoice_date: '',
            due_date: '',
            discount: 0,
            products: [{
                name: '',
                price: 0,
                qty: 1
            }]}"></invoice-form>
    </div>
@endsection

@section('script')
<script src="/js/app.js"></script>
@stop