@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Change password') }}</div>
                <div class="card-body">
                    <x-form::form method="POST" action="{{ route('admin.password.update') }}">

                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-md-6">
                                <x-form::input name="password_old" :label="__('Current password')" type="password" autocomplete="current-password" />
                            </div>
                        </div>

                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-md-6">
                                <x-form::input name="password" :label="__('New passowrd')" type="password" autocomplete="new-password" />
                            </div>
                        </div>

                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-md-6">
                                <x-form::input name="password_confirmation" :label="__('Confirm new password')" type="password" autocomplete="new-password"/>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </x-form::form>
                </div>
            </div>
        </div>
    </div>
@endsection
