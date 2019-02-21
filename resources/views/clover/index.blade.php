@extends('layouts.app')
@section('content')

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <p><a href="/clover/create" class="btn btn-success">新規</a></p> 
      </div>
    </div>    

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>クローバー一覧(withoutScope件数:{{$clovers_count}}件)</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
                <th>編集</th>
                <th>完全削除</th>
                <th>Soft削除</th>
                <th>解除</th>
                <th>削除日付</th>
                <th>象徵</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($clovers as $clover)
              <tr>
                <td>
                  <a href="/clover/{{$clover->clover_name}}">{{$clover->clover_name}}</a>
                </td>
                <td>
                  <a href="/clover/{{$clover->clover_name}}/edit">編集</a>
                </td>
                <td>
                  <a href="javascript:void(0)" onclick="javascript:hard_delete('{{$clover->clover_name}}')">完全削除</a>
                </td>
                <td>
                  <a href="javascript:void(0)" onclick="javascript:soft_delete('{{$clover->clover_name}}')">削除</a>
                </td>
                <td>
                  <a href="/clover/restore/{{$clover->clover_name}}" class="card-link">解除</a>
                </td>
                <td>
                  {{$clover->deleted_at}}
                </td> 
                <td>
                  {{$clover->symbol}}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
   

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>Local Scope</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($cloves_local_scope as $clover)
              <tr>
                <td>
                  <a href="/clover/{{$clover->clover_name}}/edit">{{$clover->clover_name}}</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>Has Many Relation > num </h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($clover_has as $clover)
              <tr>
                <td>
                  <a href="/clover/{{$clover->clover_name}}/edit">{{$clover->clover_name}}</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>Has Many throught Relation >= 1</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($clover_has_through as $clover)
              <tr>
                <td>
                  <a href="/clover/{{$clover->clover_name}}/edit">{{$clover->clover_name}}</a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
   
    <div class="row">
      <div class="col-sm-12">
    <form action="" method="POST" id="soft_delete">
     {{ csrf_field() }}
    <input type="hidden" name="_method" value="DELETE">
    </form>
    
    <form action="" method="POST" id="hard_delete">
     {{ csrf_field() }}
    </form>

      </div>
    </div>

@section('script')

    <script>
    function soft_delete(clover_name){
      let delete_url = "/clover/" + clover_name;
      $('#soft_delete').attr('action',delete_url);
      $('#soft_delete').submit();
    }

    function hard_delete(clover_name){
      let delete_url = "/clover/delete/" + clover_name;
      $('#hard_delete').attr('action',delete_url);
      $('#hard_delete').submit();
    } 
    </script>      

@stop