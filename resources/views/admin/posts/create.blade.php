@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">{{ __('Create a new post') }}</h5>
                <div class="card-body">
                    <x-form::form method="POST" :action="route('admin.accounts.posts.store', $account)" class="col-auto flex-grow-1" enctype="multipart/form-data" novalidate>
                        <div class="justify-content-center">
                            <div class="mt-3">
                                <x-form::input name="posted_at" label="Posted at" type="datetime-local"/>
                            </div>

                            <div class="mt-3">
                                <x-form::input name="images[]" id="images" label="Images" type="file" multiple accept="image/*" />
                            </div>

                            <div class="mt-3">
                                <x-form::textarea name="caption" label="Description" placeholder="Typ here ..." />
                            </div>

                            <div class="col mt-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </x-form::form>
                </div>
            </div>
        </div>
    </div>
@endsection
