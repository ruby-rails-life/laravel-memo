<table>
  <thead>
  <tr>
    <th>プロジェクトID</th>
    <th>プロジェクト名称</th>
    <th>受注日</th>
  </tr>
  </thead>
  <tbody>
  @foreach ($projects as $project)
    <tr>
      <td>{{ $project->id }}</td>
      <td>{{ $project->project_name }}</td>
      <td>{{ $project->order_date }}</td>
    </tr>
  @endforeach
  </tbody>
</table>