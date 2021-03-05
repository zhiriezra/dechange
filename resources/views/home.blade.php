@extends('layouts.app')

@section('content')

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if(session('message'))
                        <div 
                            class="alert @if(session('alert-type')) {{ session('alert-type') }} @endif">
                            
                            {{ session('message') }}        
                        </div>
                    @endif

                    @if(!Auth::user()->admin)
                    <div>
                        <h4>Instructions</h4>
                        <ul>
                            <li>Add account details for your profile.</li>
                            <li>Convert Currency.</li>
                        </ul>
                    </div>
                    @else
                        <div>
                            <p>Welcome {{ Auth::user()->name }}. Click on transactions to see transfer details.</p>
                        </div>
                    @endif

                    @if($user->account)
                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table table-hover">
                                <tr>
                                    <td>Account Name:</td>
                                    <td>{{ $user->account->account_name }}</td>
                                </tr>

                                <tr>
                                    <td>Account Number:</td>
                                    <td>{{ $user->account->account_number }}</td>
                                </tr>

                                <tr>
                                    <td>Account Bank:</td>
                                    <td>{{ $user->account->account_bank }}</td>
                                </tr>

                                <tr>
                                    <td>Bank Verification Number :</td>
                                    <td>{{ $user->account->bvn }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
  
@endsection
