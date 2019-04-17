<h1>{{ $project->project_name}}</h1>
<p>ステータス：@if($project->project_status <>''){{$arrProjectStatus[$project->project_status]}}@endif</p>