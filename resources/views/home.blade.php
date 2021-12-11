@extends('layouts.app')

@section('content')
<?php
/* タイムゾーン設定 */
date_default_timezone_set('Asia/Tokyo');

/* 現在の日付からその週の日曜日・土曜日の日付を取得 */
$today_of_week = date('w');
$sun_date = date("Y-m-d", strtotime("-" . $today_of_week . " day"));
$sat_date = date("Y-m-d", strtotime((6 - $today_of_week) . " day"));

/* 現在の月を取得 */
$year_and_month = date('Y-m');
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

                    <div class="search mb-3">
                        <form action="{{ url('/home') }}">
                            <input type="text" class="searchTerm" placeholder="Search with begin, end, place, content..." name="q">
                            <button type="submit" class="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <div class="text-black-50 text-center mt-2">
                        <h1>Schedules</h1>
                    </div>

                    <table class="table mt-3">
                        <tbody>
                            <tr>
                                <th>Begin</th>
                                <th>End</th>
                                <th>Place</th>
                                <th>Content</th>
                                <th></th>
                            </tr>
                            @foreach($schedules as $schedule)
                            <tr>
                                <td>{{ substr($schedule->begin, 0, 16) }}</td>
                                <td>{{ substr($schedule->end, 0, 16) }}</td>
                                <td>{{ $schedule->place }}</td>
                                <td>{{ $schedule->content }}</td>
                                <td>
                                    <div>
                                        <div class="subbutton-wrapper">
                                            <form action="{{ url('/update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $schedule->id }}">
                                                <input type="hidden" name="begin" value="{{ $schedule->begin }}">
                                                <input type="hidden" name="end" value="{{ $schedule->end }}">
                                                <input type="hidden" name="place" value="{{ $schedule->place }}">
                                                <input type="hidden" name="content" value="{{ $schedule->content }}">
                                                <button type="submit">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="subbutton-wrapper">
                                            <form action="{{ url('/removeconfirm') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $schedule->id }}">
                                                <input type="hidden" name="begin" value="{{ $schedule->begin }}">
                                                <input type="hidden" name="end" value="{{ $schedule->end }}">
                                                <input type="hidden" name="place" value="{{ $schedule->place }}">
                                                <input type="hidden" name="content" value="{{ $schedule->content }}">
                                                <button type="submit">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin: 2rem;"></div>

            <div class="card">
                <div class="card-header">Schedule Add Board</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="text-black-50 text-center mt-2">
                        <h1>Add Schedule</h1>
                    </div>

                    @if (strlen($msg))
                    <div class="assertion-wrapper mt-2">
                        <div>
                            <?php echo nl2br($msg) ?>
                        </div>
                    </div>
                    @endif

                    <form action="{{ url('/addconfirm') }}" method="POST">
                        @csrf
                        <table class="table mt-3">
                            <tbody>
                                <tr>
                                    <td class="table-cell" style="text-align: right;">Begin time</td>
                                    <td class="table-cell">
                                        <input type="date" name="begin-date" require>&nbsp;
                                        <select name="begin-hour" require>
                                            @for($i = 0;$i < 24;$i++) <option value="{{ sprintf('%02d', $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                @endfor
                                        </select>：
                                        <select name="begin-minute" require>
                                            @for($i = 0;$i < 60;$i++) <option value="{{ sprintf('%02d', $i) }}">{{ sprintf("%02d",$i) }}</option>
                                                @endfor
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-cell" style="text-align: right;">End time</td>
                                    <td class="table-cell">
                                        <input type="date" name="end-date" require>&nbsp;
                                        <select name="end-hour" require>
                                            @for($i = 0;$i < 24;$i++) <option value="{{ sprintf('%02d', $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                @endfor
                                        </select>：
                                        <select name="end-minute" require>
                                            @for($i = 0;$i < 60;$i++) <option value="{{ sprintf('%02d', $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                @endfor
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-cell" style="text-align: right;">Place</td>
                                    <td class="table-cell"><input type="text" name="place" size="30" require></td>
                                </tr>
                                <tr>
                                    <td class="table-cell" style="text-align: right;">Content</td>
                                    <td class="table-cell"><textarea name="content" cols="30" rows="3" require></textarea></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: center;"><input type="submit" value="Confirm"></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection