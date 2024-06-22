@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>テストでテンプレートタスクを表示</h1>

    {{-- デバッグ用にコレクションを表示 --}}
    <pre>{{ var_dump($templateTasks) }}</pre>

    <table>
        <tr>
            <th>題名</th>
            <th>説明</th>
            <th>開始基準日</th>
            <th>終了基準日</th>
        </tr>
        @foreach ($templateTasks as $templateTask)
        <tr>
            <td>{{ $templateTask->title }}</td>
            <td>{{ $templateTask->description }}</td>
            <td>{{ $templateTask->start_date_offset }}</td>
            <td>{{ $templateTask->end_date_offset }}</td>
        </tr>
        @endforeach
    </table>
  </div>
@endsection
