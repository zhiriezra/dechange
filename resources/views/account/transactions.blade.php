@extends('layouts.app')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Transactions') }}</div>

            <div class="card-body">
                <table class="table table-hover">
                	<thead>
                		<th>#</th>
                		<th>User</th>
                		<th>Amount</th>
                		<th>Transfered amount</th>
                		<th>Reference code</th>
                		<th>Transaction date</th>
                	</thead>
                	<tbody>
                		
                		
                			@foreach($transactions as $key => $transaction)
                            <tr>
                				<td>{{ $key + 1}}</td>
		                		<td>{{ $transaction->user->name }}</td>
		                		<td>{{ $transaction->fromcurrency->code }}{{ number_format($transaction->amount,2) }}</td>
		                		<td>{{ $transaction->tocurrency->code }}{{ number_format($transaction->converted_amount,2) }}</td>
		                		<td>{{ $transaction->refrence }}</td>
		                		<td>{{ $transaction->created_at->toDayDateTimeString() }}</td>
                            </tr>
	                		@endforeach
                		
                		
                	</tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
