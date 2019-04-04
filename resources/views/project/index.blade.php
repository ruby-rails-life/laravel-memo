@extends('layouts.proj')
@section('content')

@if(session('message'))
 <div class="bg-info">
  <p>{{ session('message') }}</p>
</div>
@endif

    <form id="searchForm" action="{{url('/project')}}">
      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="txtProjectName">プロジェクト名称</label>
          <input type="text" class="form-control" id="txtProjectName" name="project_name" value="{{$project_name}}">
        </div>
        <div class="form-group col-md-3">
          <label for="txtEstimatedDeliveryDateFrom">納期From</label>
          <input type="date" class="form-control" id="txtEstimatedDeliveryDateFrom" name="estimated_delivery_date_from" value="{{$estimated_delivery_date_from}}">
        </div>
        <div class="form-group col-md-3">
          <label for="txtEstimatedDeliveryDateTo">納期To</label>
          <input type="date" class="form-control" id="txtEstimatedDeliveryDateTo" name="estimated_delivery_date_to" value="{{$estimated_delivery_date_to}}">
        </div>
      </div>
      
      <div class="form-row mb-2">
        <div class="col-md-12 text-right">
          <button type="submit" class="btn btn-outline-primary">検索</button>
          <button id="btnClear" type="button" class="btn btn-outline-secondary">クリア</button>
          @if (Auth::user()->role == 3)
          <a href="{{url('/project/create')}}" class="btn btn-outline-success">新規</a>
          @endif
        </div>
      </div>
    </form>

    <div class="row">
      <div class="col-md-12">
        <span class="page_num"><strong>{{$projects->firstItem()}}～{{$projects->lastItem()}}</strong> 件を表示 ／ 全 <strong>{{$projects->total()}}</strong> 件</span>
      </div>
    </div> 

    <div class="table-responsive table-area">
      <table class="table table-striped table-sm text-nowrap">
        <thead>
          <tr>
            <th>ID</th>
            <th>プロジェクト名称</th>
            <th class="text-center">納期</th>
            <th class="text-center">営業担当者</th>
            <th class="text-center">開発担当者</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $project)
          <tr>
            <td><a href="/project/{{$project->id}}/edit">{{ $project->id }}</a></td>
            <td><a href="/project/{{$project->id}}">{{ $project->project_name }}</a></td>
            <td class="text-center">{{ $project->estimated_delivery_date }}</td>
            <td class="text-center">{{ $project->Sales->name }}</td>
            <td class="text-center">@if($project->developer_in_charge_id !=0){{ $project->Developer->name }}@endif</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="paginate">
          {{ $projects->appends(Request::only('project_name','estimated_delivery_date_from','estimated_delivery_date_to'))->links() }}
        </div>
      </div>
    </div>
@stop

@section('script')
<script>
    $(function(){
      $('#btnClear').click(function(e) {
        $('#txtProjectName').val('');
        $('#txtEstimatedDeliveryDateFrom').val('');
        $('#txtEstimatedDeliveryDateTo').val('');
        $('#searchForm').submit();
      });
    })
</script>
@stop