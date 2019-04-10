<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        @font-face {
            font-family: ipag;
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: ipag;
            font-style: bold;
            font-weight: bold;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }
        body {
            font-family: ipag !important;
        }
    </style>
</head>
<body>

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
</body>
</html>