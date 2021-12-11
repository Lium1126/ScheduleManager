@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Schedule Update Confirm Board</div>

				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif

					<div class="text-black-50 text-center mt-2">
						<h1>Confirm Updating Schedule</h1>
					</div>

					<table style="margin: 0 auto 0 auto;">
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
							<tr>
								<td colspan="2" style="text-align: center;">
									<form action="{{ url('/done') }}" class="mt-3" method="POST">
										@csrf
										<input type="hidden" name="id" value="{{ $schedule['id'] }}">
										<input type="hidden" name="begin" value="{{ $schedule['begin'] }}">
										<input type="hidden" name="end" value="{{ $schedule['end'] }}">
										<input type="hidden" name="place" value="{{ $schedule['place'] }}">
										<input type="hidden" name="content" value="{{ $schedule['content'] }}">
										<input type="hidden" name="jobtype" value="update">
										<input type="submit" value="Update">
									</form>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="button">
				<div class="card">
					<form name="return_to_updateform" action="{{ url('/update') }}" method="POST">
						@csrf
						<input type="hidden" name="id" value="{{ $schedule['id'] }}">
						<input type="hidden" name="begin" value="{{ $schedule['begin'] }}">
						<input type="hidden" name="end" value="{{ $schedule['end'] }}">
						<input type="hidden" name="place" value="{{ $schedule['place'] }}">
						<input type="hidden" name="content" value="{{ $schedule['content'] }}">
						<a class="in-button-link" href="javascript:return_to_updateform.submit()">
							<div class="card-body">
								&lt; To return update
							</div>
						</a>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection