@extends('layouts.app')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Add Bank Account Information') }}</div>

            <div class="card-body">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <p>{{$errors->first()}}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('store.account') }}" aria-label="{{ __('Account Detail') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="account_name" class="col-md-4 col-form-label text-md-right">{{ __('Account Name') }}</label>

                        <div class="col-md-6">
                            <input id="account_name" type="text" class="form-control{{ $errors->has('account_name') ? ' is-invalid' : '' }}" name="account_name" value="{{ old('account_name') }}" autofocus>

                            @if ($errors->has('account_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('account_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="account_number" class="col-md-4 col-form-label text-md-right">{{ __('Account Number') }}</label>

                        <div class="col-md-6">
                            <input id="account_number" type="text" class="form-control{{ $errors->has('account_number') ? ' is-invalid' : '' }}" name="account_number" value="{{ old('account_number') }}" autofocus>

                            @if ($errors->has('account_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('account_number') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="account_bank" class="col-md-4 col-form-label text-md-right">{{ __('Account Bank') }}</label>

                        <div class="col-md-6">
                           
                            <select class="form-control{{ $errors->has('bank_code') ? ' is-invalid' : '' }}" name="bank_code">
                                <option value="">Select Bank</option>
                                @foreach($bankList as $bank)
                                    <option value="{{ $bank->code}}">{{ $bank->name}}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('bank_code'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('bank_code') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="bvn" class="col-md-4 col-form-label text-md-right">{{ __('Bank Verification Number (BVN)') }}</label>

                        <div class="col-md-6">
                            <input id="bvn" type="text" class="form-control{{ $errors->has('bvn') ? ' is-invalid' : '' }}" name="bvn" value="{{ old('bvn') }}" autofocus>

                            @if ($errors->has('bvn'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('bvn') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
