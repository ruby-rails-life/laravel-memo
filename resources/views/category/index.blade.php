@extends('layouts.app')
@section('content')

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <p><a href="/category/create" class="btn btn-success">新規</a></p> 
      </div>
    </div>    

    <div class="row">
      <div class="offset-sm-2 col-sm-8">
        <h4>Category一覧</h4>
        <div class="table-responsive">
          <table class="table table-striped text-nowrap">
            <thead>
              <tr>
                <th>category name</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
              <tr>
                <td>
                  {{$category->name}}
                </td>
                <td>
                  <table class="table">
                     <thead>
              <tr>
                <th>RelationHm</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($category->relationHms as $relationHm)
                    <tr>
                      <td>
                        {{$relationHm->name}}
                      </td>
                    </tr>
            @endforeach
            </tbody>        
                  </table>  
                </td>
                <td>
                  <table class="table">
                     <thead>
              <tr>
                <th>RelationMtm</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($category->relationMtms as $relationMtm)
                    <tr>
                      <td>
                        {{$relationMtm->name}}
                      </td>
                    </tr>
            @endforeach
            </tbody>        
                  </table>  
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

@stop