@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">Schedule Update Board</div>

				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif

					@if (strlen($msg))
					<div class="assertion-wrapper">
						<div>
							<?php echo nl2br($msg) ?>
						</div>
					</div>
					@endif

					<div class="text-black-50 text-center mt-2">
						<h1>Update Schedule</h1>
					</div>

					<form action="{{ url('/updateconfirm') }}" method="POST">
						@csrf
						<table class="table">
							<tbody>
								<tr>
									<td class="table-cell" style="text-align: right;">Begin time</td>
									<td class="table-cell">
										<input type="date" name="begin-date" require value="{{ substr($schedule['begin'], 0, 10) }}">&nbsp;
										<select name="begin-hour" require>
											@for($i = 0;$i < 24;$i++) @if (intval(substr($schedule['begin'], 11, 2))==$i) <option value="{{ sprintf('%02d', $i) }}" selected>{{ sprintf('%02d', $i) }}</option>
												@else
												<option value="{{ sprintf('%02d', $i) }}">{{ sprintf("%02d", $i) }}</option>
												@endif
												@endfor
										</select>：
										<select name="begin-minute" require>
											@for($i = 0;$i < 60;$i++) @if (intval(substr($schedule['begin'], 14, 2))==$i) <option value="{{ sprintf('%02d', $i) }}" selected>{{ sprintf('%02d', $i) }}</option>
												@else
												<option value="{{ sprintf('%02d', $i) }}">{{ sprintf("%02d", $i) }}</option>
												@endif
												@endfor
										</select>
									</td>
								</tr>
								<tr>
									<td class="table-cell" style="text-align: right;">End time</td>
									<td class="table-cell">
										<input type="date" name="end-date" require value="{{ substr($schedule['end'], 0, 10) }}">&nbsp;
										<select name="end-hour" require>
											@for($i = 0;$i < 24;$i++) @if (intval(substr($schedule['end'], 11, 2))==$i) <option value="{{ sprintf('%02d', $i) }}" selected>{{ sprintf('%02d', $i) }}</option>
												@else
												<option value="{{ sprintf('%02d', $i) }}">{{ sprintf("%02d", $i) }}</option>
												@endif
												@endfor
										</select>：
										<select name="end-minute" require>
											@for($i = 0;$i < 60;$i++) @if (intval(substr($schedule['end'], 14, 2))==$i) <option value="{{ sprintf('%02d', $i) }}" selected>{{ sprintf('%02d', $i) }}</option>
												@else
												<option value="{{ sprintf('%02d', $i) }}">{{ sprintf("%02d", $i) }}</option>
												@endif
												@endfor
										</select>
									</td>
								</tr>
								<tr>
									<td class="table-cell" style="text-align: right;">Place</td>
									<td class="table-cell"><input type="text" name="place" size="30" require value="{{ $schedule['place'] }}"></td>
								</tr>
								<tr>
									<td class="table-cell" style="text-align: right;">Content</td>
									<td class="table-cell"><textarea name="content" cols="30" rows="3" require>{{ $schedule['content'] }}</textarea></td>
								</tr>
								<tr>
									<input type="hidden" name="id" value="{{ $schedule['id'] }}">
									<td colspan="2" style="text-align: center;"><input type="submit" value="Confirm"></td>
								</tr>
							</tbody>
						</table>
					</form>
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