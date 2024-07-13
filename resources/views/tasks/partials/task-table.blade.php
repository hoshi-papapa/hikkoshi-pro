<table class="table">
    <thead>
        <tr>
            <th>完了・未完了</th>
            <th>タイトル</th>
            <th>説明</th>
            <th>開始日</th>
            <th>終了日</th>
            <th>アクション</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr class="clickable-row">
                <td>
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
                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">{{ $task->title }}</td>
                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">{{ $task->description }}</td>
                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">{{ $task->start_date }}</td>
                <td data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">{{ $task->end_date }}</td>
                <td>
                    <button class="btn btn-sm btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#deleteTaskModal{{ $task->id }}">削除</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>