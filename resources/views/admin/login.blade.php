@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <x-form::form method="POST" action="{{ route('admin.login') }}">

                        <div class="row md-3 d-flex justify-content-center">
                            <div class="col-md-6 mb-3">
                                <x-form::input name="email" label="Email" placeholder="Enter your email address" type="email" autocomplete="username" />
                            </div>
                        </div>

                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-md-6">
                                <x-form::input name="password" label="Password" type="password" autocomplete="current-password" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-3">
                                <x-form::checkbox name="remember" value="yes" label="Remember me" />
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </x-form::form>
                </div>
            </div>
        </div>
    </div>
@endsection
