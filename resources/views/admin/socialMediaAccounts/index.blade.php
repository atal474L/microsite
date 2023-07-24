@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <x-form::form method="POST" :action="route('admin.accounts.store')">
                <div class="row justify-content-end gy-3">
                    <div class="col-auto flex-grow-1">
                        <x-form::input name="name" label="Name" placeholder="Enter your name" type="text" />
                    </div>

                    <div class="col-auto flex-grow-1" >
                        <x-form::select name="social_media_id" label="Social media" :options="$socialMedias" />
                    </div>

                    <div class="col-auto mt-auto">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </x-form::form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                <tr>
                    <th>Social media</th>
                    <th>Name</th>
                    <th>Number of posts</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($accounts as $account)
                    <tr>
                        <td>{{ $account->socialMedia->name }}</td>
                        <td>{{ $account->name }}</td>
                        <td>{{ $account->posts_count }}</td>
                        <td>
                            {{ $account->profile_id && $account->access_token ? __('Connected') : __('Not connected') }}
                        </td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.accounts.posts.create', $account) }}">Add post</a>
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.posts.index') }}">View posts</a>
                            <a class="btn btn-sm btn-success" href="{{ route('instagram.login', $account) }}">Connect</a>
                            <a class="btn btn-sm btn-danger delete" href="{{ route('admin.accounts.destroy', $account) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection


