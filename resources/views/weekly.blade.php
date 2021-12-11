@extends('layouts.app')

@section('content')
<?php
/* タイムゾーン設定 */
date_default_timezone_set('Asia/Tokyo');

/* 現在の月を取得 */
$year_and_month = date('Y-m');

/* scheduleを曜日ごとに分割 */
for ($i = $sun; $i != date("Y-m-d", strtotime($sat . "+1 day")); $i = date("Y-m-d", strtotime($i . "+1 day"))) {
    $data[$i] = [];
}

foreach ($schedules as $schedule) {
    array_push($data[substr($schedule->begin, 0, 10)], $schedule);
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="text-center">
                <div class="button" style="width: 100%;">
                    <div class="card">
                        <form name="monthly_link" action="{{ url('/monthly') }}">
                            <input type="hidden" name="year-and-month" value="{{ $year_and_month }}">
                            <a class="in-button-link" href="javascript:monthly_link.submit()">
                                <div class="card-body">
                                    Monthly Schedules
                                </div>
                            </a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header">Schedule Display Board</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="text-black-50 text-center mt-2">
                        <h1>Schedules</h1>
                    </div>

                    <table class="table mt-3 table-bordered">
                        <tr>
                            <td style="color: red;">日</td>
                            <td>月</td>
                            <td>火</td>
                            <td>水</td>
                            <td>木</td>
                            <td>金</td>
                            <td style="color: blue;">土</td>
                        </tr>
                        <tr>
                            @for ($i = $sun;$i != date("Y-m-d", strtotime($sat."+1 day"));$i = date("Y-m-d", strtotime($i."+1 day")))
                            @if ($i == $sun)
                            <td style="color: red;">
                                @elseif ($i == $sat)
                            <td style="color: blue;">
                                @else
                            <td>
                                @endif
                                {{ str_replace("-", "/", substr($i, 5)) }}
                            </td>
                            @endfor
                        </tr>
                        <tr>
                            @for ($i = $sun;$i != date("Y-m-d", strtotime($sat."+1 day"));$i = date("Y-m-d", strtotime($i."+1 day")))
                            <td>
                                @foreach ($data[$i] as $schedule)
                                <p>{{ $schedule->content }}</p>
                                @endforeach
                            </td>
                            @endfor
                        </tr>
                    </table>

                    <div class="text-center pagination-lg">
                        <span class="mr-5">
                            <form action="{{ url('weekly') }}" name="before_week" style="display: inline">
                                <input type="hidden" name="sun-date" value="{{ date('Y-m-d', strtotime($sun.'-1 week')) }}">
                                <input type="hidden" name="sat-date" value="{{ date('Y-m-d', strtotime($sat.'-1 week')) }}">
                                <a href="javascript:before_week.submit()">
                                    &lt;&nbsp;Previous week
                                </a>
                            </form>
                        </span>
                        <span class="ml-5">
                            <form action="{{ url('weekly') }}" name="next_week" style="display: inline">
                                <input type="hidden" name="sun-date" value="{{ date('Y-m-d', strtotime($sun.'+1 week')) }}">
                                <input type="hidden" name="sat-date" value="{{ date('Y-m-d', strtotime($sat.'+1 week')) }}">
                                <a href="javascript:next_week.submit()">
                                    Next week&nbsp;&gt;
                                </a>
                            </form>
                        </span>
                    </div>
                </div>
            </div>

            <div class="button">
                <div class="card">
                    <a class="in-button-link" href="{{ url('/home') }}">
                        <div class="card-body">
                            &lt; To return home
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection