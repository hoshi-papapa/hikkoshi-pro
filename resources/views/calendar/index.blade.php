@extends('layouts.app')

@section('head')    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/google-calendar@6.1.15/index.global.min.js"></script>
@endsection

@section('content')
<div class="container" style="max-width: 800px;">    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @if ($selectedSubUser)
                <li class="breadcrumb-item"><a href="{{ route('calendar.index') }}">やることカレンダー</a></li>
                <li class="breadcrumb-item active text-mycolor1" aria-current="page">{{ $selectedSubUser->nickname }}さんのやることカレンダー</li>
            @else
                <li class="breadcrumb-item active text-mycolor1" aria-current="page">やることカレンダー</li>
            @endif
        </ol>
    </nav>

    <!-- サブユーザー選択フォーム -->
    <form method="GET" action="{{ route('calendar.index') }}" id="subUserForm">
        <div class="form-group">
            <label for="sub_user_id">ユーザーを選択</label>
            <select name="sub_user_id" id="sub_user_id" class="form-control" onchange="document.getElementById('subUserForm').submit();">
                <option value="">すべてのユーザー</option>
                @foreach ($subUsers as $subUser)
                    <option value="{{ $subUser->id }}" {{ $selectedSubUserId == $subUser->id ? 'selected' : '' }}>
                        {{ $subUser->nickname }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="container mt-3">
        <div id="calendar">
        </div>
        <p class="text-mycolor1">※完了しているタスクは、やることカレンダーに表示されません</p>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var subUserId = document.getElementById('sub_user_id').value;
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {

            googleCalendarApiKey: 'AIzaSyDkGqlgR5Q56Fl5sn9vHhF8O_zfbG-tZmQ',            
            eventSources: [
                {
                    googleCalendarId: 'ja.japanese#holiday@group.v.calendar.google.com', //日本の休日
                    className: 'holidays',
                    textColor: 'red',
                    backgroundColor: '#ffffff00',
                    borderColor: '#ffffff00'
                },
                {
                    url: '{{ route('calendar.getEvents') }}' + '?sub_user_id=' + subUserId, //自分のタスク
                    className: 'my-events'
                }
            ],

            headerToolbar: {
                left: "prev today",
                center: "title",
                right: "today next"
            },

            initialView: 'dayGridMonth',
            locale: 'ja',
            height: 'auto',
            firstDay: 0,
            buttonText: {
                today: '今月',
            },
            noEventsContent: 'タスクはありません',

            // 最大数を決められるが逆に見づらいため保留
            // dayMaxEventRows: true,
            // views: {
            //     dayGrid: {
            //         dayMaxEventRows: 6
            //     }
            // },

            dayCellContent: function (e) {
                return e.dayNumberText.replace('日', '');
            },
            eventSourceFailure () { 
                console.error('エラーが発生しました。');
            },
            eventMouseEnter (info) {
                $(info.el).popover({
                    title: info.event.title,
                    content: info.event.extendedProps.description,
                    trigger: 'hover',
                    placement: 'top',
                    container: 'body',
                    html: true
                });
            },
        });
        
        calendar.render();
    });
</script>

@endsection
