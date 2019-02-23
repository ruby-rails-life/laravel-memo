@extends('layouts.app')
@section('content')

    <div class="row mt-3">
      <div class="offset-sm-2 col-sm-1">
        <p><a href="/relationNullable/create" class="btn btn-success">新規</a></p> 
      </div>
      <div class="col-sm-2">
        <p><a href="/relationNullable_res" class="btn btn-success">Resource</a></p> 
      </div>
      <div class="col-sm-2">
        <p><a href="/relationNullable_col" class="btn btn-success">Collection</a></p> 
      </div>
    </div>    

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>RelationNullable一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>名前</th>
                <th>RelationMtm</th>
                <th>NameUpdatedAt</th>
                <th>Edit</th>
                <th>dissociate</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($relationNullables as $relationNullable)
              <tr>
                <td>
                  <a href="/relationNullable/{{$relationNullable->id}}">{{$relationNullable->name}}</a>
                </td>
                <td>
                 @if ($relationNullable->relationMtm)
                 {{$relationNullable->relationMtm->name}}
                 @endif
                </td>
                <td>
                  {{$relationNullable->name_updated_at}}
                </td>  
                <td>
                  <a href="/relationNullable/{{$relationNullable->id}}/edit">Edit</a>
                </td>  
                <td>
                  <a href="javascript:(0)" onclick="dissociate({{$relationNullable->id}})">dissociate</a>
                </td>  
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        {{ $relationNullables->links() }}
        {{ $relationNullables->appends(['sort' => 'name'])->links() }}
        {{ $relationNullables->fragment('foo')->links() }}
        {{ $relationNullables->onEachSide(5)->links() }}
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
   
    <form action="" method="POST" id="dissociate">
     {{ csrf_field() }}
    </form>

      </div>
    </div>

    @section('script')

    <script>
    function dissociate(id){
      let dissociate_url = "/relationNullable/dissociate/" + id;
      $('#dissociate').attr('action',dissociate_url);
      $('#dissociate').submit();
    }
    </script>    

@stop