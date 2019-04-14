@extends('layouts.proj')
@section('content')
    <h4>プロジェクト新規</h4>
    <br/>
<!--     @foreach($errors->all() as $message)
    <p class="bg-danger">{{ $message }}</p>
    @endforeach -->

    <form method="post" action="/project" enctype="multipart/form-data">
       @csrf
      <div class="form-group row">
        <label for="txtProjectName" class="col-md-2 col-form-label">プロジェクト名称</label>
        <div class="col-md-10">
          <input type="text" class="form-control @if($errors->has('project_name')) is-invalid @endif" id="txtProjectName" name="project_name" value="{{ old('project_name') }}">
          @if($errors->has('project_name')) 
          <span class="invalid-feedback">{{ $errors->first('project_name') }}</span> 
          @endif
        </div>
      </div>

      <div class="form-group row">
        <label for="txtOrderDate" class="col-md-2 col-form-label">受注日</label>
        <div class="col-md-10">
          <input type="date" class="form-control" id="txtOrderDate" name="order_date" value="{{ old('order_date') }}">
        </div>
      </div>

      <div class="form-group row">
        <label for="cbxProjectStatus" class="col-md-2 col-form-label">ステータス</label>
        <div class="col-md-10">
          <select class="custom-select" id="cbxProjectStatus" name="project_status">
            <option value="">選択...</option>
            @foreach ($arrProjectStatus as $key => $value)
            <option value="{{$key}}" @if(old('project_status')==$key) selected @endif>{{$value}}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="txtEstimatedDeliveryDate" class="col-md-2 col-form-label">納期</label>
        <div class="col-md-10">
          <input type="date" class="form-control" id="txtEstimatedDeliveryDate" name="estimated_delivery_date" value="{{ old('estimated_delivery_date') }}">
        </div>
      </div>

      <div class="form-group row">
        <label class="col-md-2 col-form-label">画像</label>
        <div class="col-md-10">
          <div class="input-group">
            <div class="custom-file">
              <input type="file" id="txtProjectImage" name="project_image" class="custom-file-input @if($errors->has('project_image')) is-invalid @endif">
              <label class="custom-file-label" for="txtProjectImage">ファイル選択...</label>
            </div>
            <div class="input-group-append">
              <button type="button" class="btn btn-outline-secondary file-reset">取消</button>
            </div>
          </div>
          @if($errors->has('project_image')) 
            <span class="invalid-feedback" style="display:block">{{ $errors->first('project_image') }}</span> 
          @endif
        </div>
      </div>
      
      <div class="form-group row">
        <div class="offset-md-2 col-md-10">
          <button type="submit" class="btn btn-primary">登録</button>
          <a href="/project/" class="btn btn-secondary">キャンセル</a>
        </div>
      </div>
    </form>

@stop

@section('script')
<script>
  $(function(){
    $('.custom-file-input').on('change',function(){
      $(this).next('.custom-file-label').html($(this)[0].files[0].name);
    })
    $('.file-reset').click(function(){
      $(this).parent().prev().children('.custom-file-label').html('ファイル選択...');
    })
  })
</script>
@stop  