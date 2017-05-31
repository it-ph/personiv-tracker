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
		@if($account->batchable)
			<th colspan="5" align="center">Total</th>
		@else
			<th colspan="3" align="center">Total</th>
		@endif
	</tr>
	@foreach($account->positions as $position)
		<tr>
			<th align="center">{{$position->name}}</th>
			@foreach($account->reportDates as $date)
				<th align="center">New</th>
				@if($account->batchable)
					<th align="center">Batch Photos (New)</th>
				@endif
				<th align="center">Revisions</th>
				@if($account->batchable)
					<th align="center">Batch Photos (Revisions)</th>
				@endif
				<th align="center">Hours Spent</th>
				<td align="center"></td>
			@endforeach
			<th align="center">New</th>
			@if($account->batchable)
				<th align="center">Batch Photos (New)</th>
			@endif
			<th align="center">Revisions</th>
			@if($account->batchable)
				<th align="center">Batch Photos (Revisions)</th>
			@endif
			<th align="center">Hours Spent</th>
		</tr>
		@foreach($position->employees as $employee)
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
				<td align="center">{{$employee->total_new}}</td>
				@if($account->batchable)
					<td align="center">{{$employee->total_number_of_photos_new}}</td>
				@endif
				<td align="center">{{$employee->total_revisions}}</td>
				@if($account->batchable)
					<td align="center">{{$employee->total_number_of_photos_revisions}}</td>
				@endif
				<td align="center">{{$employee->total_hours_spent}}</td>
			</tr>
		@endforeach
		<tr></tr>
	@endforeach
</table>
