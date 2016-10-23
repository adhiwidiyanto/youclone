<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Requests\CreateVoteRequest;

class VideoVoteController extends Controller
{
	public function create(Request $request, Video $video)
	{
		$this->authorize('vote', $video);

		$video->voteFromUser($request->user())->delete();

		$video->votes()->create([
			'type' => $request->type,
			'user_id' => $request->user()->id,
		]);

		return response()->json(null, 200);
	}

	public function remove(Request $request, Video $video)
	{
		$this->authorize('vote', $video);

		$video->voteFromUser($request->user())->delete();
		
		return response()->json(null, 200);
	}

    public function show(Request $request, Video $video)
    {
    	// Set default value on response
    	$response = [
    		'up' => null,
    		'down' => null,
    		'can_vote' => $video->votesAllowed(),
    		'user_vote' => null
    	];

    	// Check if votes are allowed
    	if ($video->votesAllowed()) {
    		$response['up'] = $video->upVotes()->count();
    		$response['down'] = $video->downVotes()->count();    	
    	}

    	// Check user vote
    	if ($request->user()) {
    		$voteFromUser = $video->voteFromUser($request->user())->first();

    		$response['user_vote'] = $voteFromUser ? $voteFromUser : null;
    	}

    	return response()->json([
    		'data' => $response
    	], 200);
    }
}

