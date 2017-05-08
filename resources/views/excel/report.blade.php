<table>
	<tr>
		<th align="center"></th>
		@foreach($account->reportDates as $date)
			<th colspan="3" align="center">{{$date}}</th>
			<th align="center"></th>
		@endforeach
	</tr>
	<tr>
		<th align="center">Name</th>
		@foreach($account->reportDates as $date)
			<th align="center">New</th>
			<th align="center">Revisions</th>
			<th align="center">Hours Spent</th>
			<td align="center"></td>
		@endforeach
	</tr>
	@foreach($account->employees as $employee)
		<tr>
			<td align="center">{{$employee->name}}</td>
			@foreach($employee->data as $item)
				<td align="center">{{$item['new']}}</td>
				<td align="center">{{$item['revisions']}}</td>
				<td align="center">{{$item['hours_spent']}}</td>
				<td align="center"></td>
			@endforeach
		</tr>
	@endforeach
</table>