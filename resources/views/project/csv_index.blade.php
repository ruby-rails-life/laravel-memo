@extends('layouts.proj')
@section('content')
  <form method="post" action="/project/csv_import" enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
      <div class="col-md-6">
        <div class="input-group">
          <div class="custom-file">
            <input type="file" id="fileUpload" name="file_upload" class="custom-file-input">
            <label class="custom-file-label" for="fileUpload">ファイル選択...</label>
          </div>
          <div class="input-group-append">
            <button type="button" class="btn btn-outline-secondary file-reset">取消</button>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-outline-primary">Upload</button>
      </div>
    </div>  
  </form>
  @foreach($errors as $message)
    <p class="text-danger">{{ $message }}</p>
  @endforeach

  @if (isset($csv_info))
    @foreach($csv_info as $info)
      <p class="text-success">{{ $info }}</p>
    @endforeach  
  @endif

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