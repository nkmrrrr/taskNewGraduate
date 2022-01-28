@extends('layouts.app')
@php
$thisDateStr = $thisDate->isoformat('YYYY-MM');
$prevMonthStr = $prevMonth->isoformat('YYYY-MM');
$nextMonthStr = $nextMonth->isoformat('YYYY-MM');
@endphp

@section('title')Calendar {{ $thisDateStr }}@endsection

@section('content')
    <div class="container">
        <div class="calendarHeader d-flex p-2">
            <h3 class="dateTitle h3">{{ $thisDateStr }}</h3>
            <div class="ms-auto d-flex">
                <a class="d-block btn btn-primary shadow-sm"
                    href="{{ route('calendar.show', ['date' => $prevMonthStr]) }}">先月</a>
                <a class="d-block btn btn-primary shadow-sm ms-3"
                    href="{{ route('calendar.show', ['date' => $nextMonthStr]) }}">来月</a>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach (['月', '火', '水', '木', '金', '土', '日'] as $dayOfWeek)
                        <th class="text-center">{{ $dayOfWeek }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($dates as $date)
                    @if ($date->dayOfWeek == 1)
                        <tr>
                    @endif

                    @if ($date->month == $thisDate->month)
                        @php
                            $dateStr = $date->toDateString();
                            $isHoliday = array_key_exists($dateStr, $holidays);
                        @endphp
                        <td
                            class="p-2 day {{ $dateStr == $current ? 'bg-warning bg-gradient' : '' }} {{ $date->isSaturday() ? 'text-primary' : '' }}{{ $date->isSunday() ? 'text-danger' : '' }} {{ $isHoliday ? 'text-success' : '' }}">
                            <div class="day_header">
                                @include('createEventModal')
                            </div>
                            <div id="event_list_{{ $dateStr }}">
                                @foreach ($events as $event)
                                    @if ($event->event_date == $dateStr)
                                        <div>
                                            @include('editEventModal')
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    @else
                        <td></td>
                    @endif

                    @if ($date->dayOfWeek == 0)
                        </tr>
                    @endif

                @endforeach
            </tbody>
        </table>
    </div>
@endsection
