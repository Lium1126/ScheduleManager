@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Result Board</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="text-black-50 text-center mt-2">
                        <h1>Result</h1>
                    </div>

                    @if ($result)
                    <div class="success-wrapper mt-2">
                        <div>{{ $msg }}</div>
                    </div>
                    @else
                    <div class="aseertion-wrapper mt-2">
                        <div>{{ $msg }}</div>
                    </div>
                    @endif

                    <table class="table mt-3">
                        <tbody>
                            <tr>
                                <td class="table-cell" style="text-align: right;">Begin time</td>
                                <td class="table-cell">{{ $schedule["begin"] }}</td>
                            </tr>
                            <tr>
                                <td class="table-cell" style="text-align: right;">End time</td>
                                <td class="table-cell">{{ $schedule["end"] }}</td>
                            </tr>
                            <tr>
                                <td class="table-cell" style="text-align: right;">Place</td>
                                <td class="table-cell">{{ $schedule["place"] }}</td>
                            </tr>
                            <tr>
                                <td class="table-cell" style="text-align: right;">Content</td>
                                <td class="table-cell">{{ nl2br($schedule["content"]) }}</textarea></td>
                            </tr>
                        </tbody>
                    </table>
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