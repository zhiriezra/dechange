@extends('layouts.app')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Change Currency') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
                    <div class="row" style="margin-bottom:40px;">
                        <div class="col-md-12">
                            <p>
                                <div>
                                    <table class="table table-hover">
                                        <tr>
                                            <td>Amount to be changed</td>
                                            <td>{{ $orderTrnx->fromcurrency->code }}{{ number_format($orderTrnx->amount, 2) }}</td>
                                        </tr>

                                        <tr>
                                            <td>Amount equivalent (NGN)</td>
                                            <td>NGN{{ number_format($orderTrnx->converted_amount, 2) }}</td>
                                        </tr>

                                        <tr>
                                            <td>Service charge:</td>
                                            <td>NGN{{ number_format($charge,2 ) }}</td>
                                        </tr>

                                        <tr>
                                            <td>You will be debited:</td>
                                            <td>NGN{{ number_format($orderTrnx->converted_amount+$charge,2 ) }}</td>
                                        </tr>

                                    </table>
                                    
                                </div><hr>

                                <p>
                                    Amount will be transfered to your provided details
                                    <ul>
                                        <li>{{ Auth::user()->account->account_number }}</li>
                                        <li>{{ Auth::user()->account->account_bank }}</li>
                                        <li>{{ Auth::user()->account->account_name }}</li>

                                    </ul>
                                </p>
                            </p>
                            <input type="hidden" name="email" value="{{ $orderTrnx->user->email }}"> {{-- required --}}
                            <input type="hidden" name="orderID" value="{{ $orderTrnx->id }}">
                            <input type="hidden" name="amount" value="{{ $orderTrnx->converted_amount * 100 }}"> {{-- required in kobo --}}
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="currency" value="NGN">
                            <input type="hidden" name="metadata" value="{{ json_encode($array = ['transaction_id' => $orderTrnx->id, ]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
                            <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                            {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> {{-- employ this in place of csrf_field only in laravel 5.0 --}}

                            <p>
                                <button class="btn btn-success btn-lg btn-block" type="submit" value="Make Transfer">
                                    <i class="fa fa-plus-circle fa-lg"></i> Make Transfer
                                </button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection