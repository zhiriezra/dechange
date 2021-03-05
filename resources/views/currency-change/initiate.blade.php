@extends('layouts.app')

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Change Currency') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('confirm.currency.change') }}" aria-label="{{ __('Account Detail') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="from_currency" class="col-md-4 col-form-label text-md-right">{{ __('From Currency') }}</label>

                        <div class="col-md-6">
                           
                            <select class="form-control{{ $errors->has('from_currency') ? ' is-invalid' : '' }}" name="from_currency">
                                <option value="">--Select Currency--</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->code }} - {{ $currency->currency }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('from_currency'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('from_currency') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="to_currency" class="col-md-4 col-form-label text-md-right">{{ __('To Currency') }}</label>

                        <div class="col-md-6">
                            
                            <select class="form-control{{ $errors->has('to_currency') ? ' is-invalid' : '' }}" name="to_currency">
                                <option value="">--Select Currency--</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->code }} - {{ $currency->currency }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('to_currency'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('to_currency') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount') }}</label>

                        <div class="col-md-6">
                            <input id="amount" type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" autofocus>

                            @if ($errors->has('amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>



                   

                    
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Pay') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
