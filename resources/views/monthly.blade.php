@extends('layouts.app')

@section('content')
<?php
/* タイムゾーン設定 */
date_default_timezone_set('Asia/Tokyo');

/* 現在の日付からその週の日曜日・土曜日の日付を取得 */
$today_of_week = date('w');
$sun_date = date("Y-m-d", strtotime("-" . $today_of_week . " day"));
$sat_date = date("Y-m-d", strtotime((6 - $today_of_week) . " day"));

/* $data["日付"] = [schedule1, schedule2...]という形式に格納 */
for ($i = date('Y-m-d', strtotime($year . '-' . $month . '-01')); date('m', strtotime($i)) == $month; $i = date("Y-m-d", strtotime($i . "+1 day"))) {
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
                        <form name="weekly_link" action="{{ url('/weekly') }}">
                            <input type="hidden" name="sun-date" value="{{ $sun_date }}">
                            <input type="hidden" name="sat-date" value="{{ $sat_date }}">
                            <a class="in-button-link" href="javascript:weekly_link.submit()">
                                <div class="card-body">
                                    Weekly Schedules
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

                    <div class="text-center">
                        <h5>{{ $year }}</h5>
                        <h1>{{ $month }}</h1>
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
                        <?php $cnt = 0; ?>
                        <tr>
                            @for ($i = 0; $i < date('w', strtotime($year . '-' . $month . '-01' )); $i++) <td>
                                </td>
                                <?php $cnt++; ?>
                                @endfor

                                <?php $cntdate = date('Y-m-d', strtotime($year . '-' . $month . '-01')); ?>
                                @while (date('m', strtotime($cntdate)) == $month)
                                <td>
                                    @if ($cnt == 0)
                                    <h6 style="color: red;">
                                        @elseif ($cnt == 6)
                                        <h6 style="color: blue;">
                                            @else
                                            <h6>
                                                @endif
                                                {{ substr($cntdate, 8, 2) }}
                                            </h6>

                                            @foreach($data[$cntdate] as $schedule)
                                            <p>{{ $schedule->content }}</p>
                                            @endforeach
                                </td>
                                <?php $cnt++; ?>
                                @if ($cnt == 7)
                                <?php $cnt = 0 ?>
                        </tr>
                        <tr>
                            @endif
                            <?php $cntdate = date('Y-m-d', strtotime($cntdate . "+1 day")); ?>
                            @endwhile

                            @while ($cnt != 7)
                            <td></td>
                            <?php $cnt++ ?>
                            @endwhile
                        </tr>
                    </table>

                    <div class="text-center pagination-lg">
                        <span class="mr-5">
                            <form action="{{ url('monthly') }}" name="before_month" style="display: inline">
                                <input type="hidden" name="year-and-month" value="{{ date('Y-m', strtotime($year . '-' . $month . '-01 -1 month')) }}">
                                <a href="javascript:before_month.submit()">
                                    &lt;&nbsp;Previous month
                                </a>
                            </form>
                        </span>
                        <span class="ml-5">
                            <form action="{{ url('monthly') }}" name="next_month" style="display: inline">
                                <input type="hidden" name="year-and-month" value="{{ date('Y-m', strtotime($year . '-' . $month . '-01 +1 month')) }}">
                                <a href="javascript:next_month.submit()">
                                    Next month&nbsp;&gt;
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