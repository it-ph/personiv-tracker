<table>
	<tr>
		<th align="center"></th>
		@foreach($account->reportDates as $date)
			@if($account->batchable)
				<th colspan="5" align="center">{{$date}}</th>
			@else
				<th colspan="3" align="center">{{$date}}</th>
			@endif
			<th align="center"></th>
		@endforeach
	</tr>
	@if($account->batchable)
		<tr>
			<th align="center">Name</th>
			@foreach($account->reportDates as $date)
				<th align="center">New</th>
				<th align="center">Batch Photos (New)</th>
				<th align="center">Revisions</th>
				<th align="center">Batch Photos (Revisions)</th>
				<th align="center">Hours Spent</th>
				<td align="center"></td>
			@endforeach
		</tr>
	@else
		<tr>
			<th align="center">Name</th>
			@foreach($account->reportDates as $date)
				<th align="center">New</th>
				<th align="center">Revisions</th>
				<th align="center">Hours Spent</th>
				<td align="center"></td>
			@endforeach
		</tr>
	@endif
	@foreach($account->employees as $employee)
		<tr>
			<td align="center">{{$employee->name}}</td>
			@foreach($employee->data as $item)
				<td align="center">{{$item['new']}}</td>
				@if($account->batchable)
					<td align="center">{{$item['number_of_photos_new']}}</td>
				@endif
				<td align="center">{{$item['revisions']}}</td>
				@if($account->batchable)
					<td align="center">{{$item['number_of_photos_revisions']}}</td>
				@endif
				<td align="center">{{$item['hours_spent']}}</td>
				<td align="center"></td>
			@endforeach
		</tr>
	@endforeach
</table>