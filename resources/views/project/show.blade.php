@extends('layouts.proj')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{url('/project')}}">プロジェクト管理</a>
          </li>
          <li class="breadcrumb-item active">
            プロジェクト詳細
          </li>
        </ol>
      </nav>
    </div>
  </div>
  
  <table class="table table-sm table-bordered">
    <tbody>
      <tr>
        <td class="field-bg-color">プロジェクト名称</td>
        <td>{{$project->project_name}}</td>
      </tr>
      <tr>
        <td class="field-bg-color">受注日</td>
        <td>{{$project->order_date}}</td>
      </tr>
      <tr>
        <td class="field-bg-color">ステータス</td>
        <td>@if($project->project_status <>''){{$arrProjectStatus[$project->project_status]}}@endif</td>
      </tr>
      <tr>
        <td class="field-bg-color">進捗</td>
        <td>{{ $project->development_progress}}</td>
      </tr>
      <tr>
        <td class="field-bg-color">納期</td>
        <td>{{$project->estimated_delivery_date}}</td>
      </tr>
      <tr>
        <td class="field-bg-color">営業担当者</td>
        <td>@if($project->sales_staff_id !=0){{$project->Sales->name }}@endif</td>
      </tr>
      <tr>
        <td class="field-bg-color">開発担当者</td>
        <td>@if($project->developer_in_charge_id !=0){{ $project->Developer->name }}@endif</td>
      </tr>
    </tbody>
  </table>    
         
@stop