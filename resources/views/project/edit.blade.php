@extends('layouts.proj')
@section('content')
    <h4>プロジェクト編集</h4>
    <br/>
    @foreach($errors->all() as $message)
    <p class="bg-danger">{{ $message }}</p>
    @endforeach

    <form method="post" action="/project/{{$project->id}}">
       @csrf
       @method('PUT')
      <div class="form-group row">
        <label for="txtProjectName" class="col-md-2 col-form-label">プロジェクト名称</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="txtProjectName" name="project_name" value="{{ $project->project_name }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="txtOrderDate" class="col-md-2 col-form-label">受注日付</label>
        <div class="col-md-10">
          <input type="date" class="form-control" id="txtOrderDate" name="order_date" value="{{ $project->order_date }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="cbxProjectStatus" class="col-md-2 col-form-label">ステータス</label>
        <div class="col-md-10">
          <select class="custom-select" id="cbxProjectStatus" name="project_status">
            <option value="">選択...</option>
            @foreach ($arrProjectStatus as $key => $value)
            <option value="{{$key}}" 
            @if($key == $project->project_status)selected="selected"@endif>{{$value}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="txtDevelopmentProgress" class="col-md-2 col-form-label">納期</label>
        <div class="col-md-10">
          <input type="text" class="form-control" id="txtDevelopmentProgress" name="development_progress" value="{{ $project->development_progress }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="txtEstimatedDeliveryDate" class="col-md-2 col-form-label">納期</label>
        <div class="col-md-10">
          <input type="date" class="form-control" id="txtEstimatedDeliveryDate" name="estimated_delivery_date" value="{{ $project->estimated_delivery_date }}">
        </div>
      </div>
      
      <div class="form-group row">
        <div class="offset-md-2 col-md-10">
          <button type="submit" class="btn btn-primary">編集</button>
          <a href="/project/" class="btn btn-secondary">キャンセル</a>
        </div>
      </div>
    </form>
 
@stop