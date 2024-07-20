@foreach ($tasks as $task)
  <div class="card my-1 border-light-subtle" style="cursor: pointer;">
    <div class="card-body">
      <div class="row">
        <div class="col-1">
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
        </div>
        <div class="col-7 col-md-8 col-lg-9" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
          {{ $task->title }}
        </div>
        <div class="col-4 col-md-3 col-lg-2" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}">
          {{ $task->end_date }}
        </div>
      </div>
    </div>
  </div>
@endforeach
