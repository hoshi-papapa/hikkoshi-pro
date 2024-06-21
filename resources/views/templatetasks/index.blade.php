@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>テストでテンプレートタスクを表示</h1>

    <table>
        <tr>
            <th>題名</th>
            <th>説明</th>
            <th>開始基準日</th>
            <th>終了基準日</th>
        </tr>
        @foreach ($templatetasks as $templatetask)
        <tr>
            <td>{{ $templatetask->title }}</td>
            <td>{{ $templatetask->description }}</td>
            <td>{{ $templatetask->start_date_offset }}</td>
            <td>{{ $protemplatetaskduct->end_date_offset }}</td>
        </tr>
        @endforeach
    </table>
  </div>

@endsection