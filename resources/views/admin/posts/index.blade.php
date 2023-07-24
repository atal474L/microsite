@extends('layouts.app')

@section('content')
    <div class="row gy-3">
        @foreach($posts as $post)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card">
                    @if($post->photos->count() > 1)
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($post->photos as $photo)
                                    <div @class(['carousel-item', 'active' => $loop->first])>
                                        <img src="{{ $photo->url }}" class="d-block w-100">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @else
                        <img src="{{ $post->photos->first()->url }}" class="d-block w-100">
                    @endif
                    <div class="card-body">
                        @isset($post->external_id)
                            <div class="badge bg-secondary mb-1">
                                Instagram
                            </div>
                        @endif
                        <h5 class="card-title">{{ $post->posted_at->format('d/m/Y H:i') }}</h5>
                        <p class="card-text">{{ $post->caption }}</p>
                        <a href="{{ route('admin.accounts.posts.destroy', [$post->socialMediaAccount, $post]) }}" class="btn btn-sm btn-danger delete">{{ __('Delete') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
