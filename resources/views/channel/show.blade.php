@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <img src="{{ $channel->getImage() }}" alt="{{ $channel->name }} image" class="media-object">
                            </div>
                            <div class="media-body">
                                {{ $channel->name }}

                                <ul class="list-inline">
                                    <li>
                                        <subsribe-button channel-slug="{{ $channel->slug }}"></subsribe-button>
                                    </li>
                                </ul>
                                @if($channel->description)
                                    <hr>
                                    <p> {{ $channel->description }} </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Video Uploaded</div>

                    <div class="panel-body">
                        @if($videos->count())
                            @foreach($videos as $video)
                                <div class="well">
                                    @include('video.partials._video_result', [
                                        'video' => $video
                                    ])
                                </div>
                            @endforeach

                            {{ $videos->links() }}
                        @else
                            <p class="text-muted"> {{ $channel->name }} has no videos</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
