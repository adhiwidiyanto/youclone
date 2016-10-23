@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Search results for {{ Request::get('q') }}</div>

                <div class="panel-body">
                    @if($channels->count())
                        <h4>Channel</h4>

                        <div class="well">
                            @foreach ($channels as $channel)
                                <div class="media">
                                    <div class="media-left">
                                        <a href="/channel/{{ $channel->slug }}">
                                            <img src="{{ $channel->getImage() }}"  alt="{{ $channel->name }}" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a href="/channel/{{ $channel->slug }}" class="media-heading">
                                            {{ $channel->name }}
                                        </a>
                                       Subscribe count
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h4 class="text-muted"> No result for channel </h4>
                    @endif

                    @if($videos->count())
                        <h4>Videos</h4>
                        @foreach($videos as $video)
                            <div class="well">
                                @include('video.partials._video_result', [
                                    'video' => $video
                                ])
                            </div>
                        @endforeach
                    @else
                        <h4 class="text-muted">No result</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
