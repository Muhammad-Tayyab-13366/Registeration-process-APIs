@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Email Verification
                    
                </div>

                <div class="card-body">
                      <form method="POST" action="{{ url('email_verification') }}">
                        @csrf
                        <div class="alert alert-info" role="alert">
                          A 6 digit pin code is sent to your email address. Please enter the code here.
                        </div>
                        <div class="row mb-3">
                            <label for="pincode" class="col-md-4 col-form-label text-md-end">{{ __('Pin Code') }}</label>

                            <div class="col-md-6">
                                <input id="pincode" type="password" class="form-control @error('pincode') is-invalid @enderror" name="pincode" value="" required autocomplete="email" autofocus>

                                @error('pincode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>

                             
                            </div>
                        </div>
                    </form>


                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
