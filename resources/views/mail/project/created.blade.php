@component('mail::message')

{{$project->project_name}}が作成されました。

@component('mail::button', ['url' => $url, 'color' => 'green'])
Button Text
@endcomponent

@component('mail::panel')
{{$project->project_name}}
@endcomponent

@component('mail::table')
| Laravel       | テーブル      | 例       |
| ------------- |:-------------:| --------:|
| 第２カラムは  | 中央寄せ      | $10      |
| 第３カラムは  | 右寄せ        | $20      |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

