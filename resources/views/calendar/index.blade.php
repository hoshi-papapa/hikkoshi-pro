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
            <li class="breadcrumb-item active" aria-current="page">やることカレンダー</li>
        </ol>
    </nav>

    <div class="container">
        <div id="calendar">
        </div>
        <p class="text-mycolor1">※全員が完了しているタスクは、やることカレンダーに表示されません</p>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                    url: '{{ route('calendar.getEvents') }}', //自分のタスク
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
