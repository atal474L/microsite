@extends('layouts.app')

@section('content')
    <div class="card">
        <h4 class="card-header">Social media</h4>
        <table class="table table-striped table-hover">
            <tbody>
                @foreach ($socialMedias as $socialMedia)
                    <tr>
                        <td>
                            <h5>{{ $socialMedia->name }}</h5>
                        </td>
                        <td>
                            <x-form::form method="PUT" :action="route('admin.socialMedias.update', $socialMedia)">
                                <div class="row flex-wrap">
                                    <div class="col-auto flex-grow-1">
                                        <x-form::input name="hashtags" :value="$socialMedia->hashtags" type="text" class="form-control-sm">
                                            <x-slot name="after">
                                                <div id="emailHelp" class="form-text">Hashtags gescheiden door een spatie</div>
                                            </x-slot>
                                        </x-form::input>
                                    </div>

                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                </div>
                            </x-form::form>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('admin.socialMedias.synchronize', $socialMedia) }}" class="btn btn-sm btn-primary">Synchronize</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
