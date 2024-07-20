<table class="table table-hover fixed-width-table">
    <thead>
        <tr>
            <th class="col1">完了・未完了</th>
            <th class="col2">タイトル</th>
            <th class="col3">説明</th>
            <th class="col4">開始日</th>
            <th class="col5">終了日</th>
            <th class="col6">アクション</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr class="clickable-row">
                <td class="col1">
                    @php
                        $allCompleted = $task->subUsers->every(fn($subUser) => $subUser->pivot->completed);
                        $allNotCompleted = $task->subUsers->every(fn($subUser) => !$subUser->pivot->completed);
                    @endphp
                    @if ($allCompleted)
                        <i class="fas fa-check-circle"></i>
                    @elseif ($allNotCompleted)
                        <i class="far fa-circle"></i>
                    @else
                        <i class="fas fa-circle"></i>
                    @endif
                </td>
                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" class="col2">{{ $task->id }} {{ $task->title }}</td>
                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" class="col3">{{ $task->description }}</td>
                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" class="col4">{{ $task->start_date }}</td>
                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" class="col5">{{ $task->end_date }}</td>
                <td class="col6">
                    <button class="btn btn-sm btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#deleteTaskModal{{ $task->id }}">削除</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>