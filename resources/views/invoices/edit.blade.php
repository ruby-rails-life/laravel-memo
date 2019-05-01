@extends('layouts.invoice')

@section('content')
    <div id="app">
        <invoice-form v-bind:pform="{{ $invoice }}"></invoice-form>
    </div>
@endsection

@section('script')
<script src="/js/app.js"></script>
@stop