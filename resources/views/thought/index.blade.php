@extends('layouts.app')
@section('content')

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>Polymorphic 1:many 一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>Content</th>
                <th>名前</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($thoughts as $thought)
              <tr>
                <td>
                  {{$thought->content}}
                </td>
                <td>
                  {{$thought->thoughtable->name}}
                </td>  
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

@stop