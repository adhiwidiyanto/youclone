<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\UploadVideo;
use App\Http\Requests;

class VideoUploadController extends Controller
{
	public function index()
	{
		return view('video.upload');
	}

	public function store(Request $request)
	{

		// Grap user channel
		$channel = $request->user()->channel()->first();

		// Lookup the video
		$video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

		// Move to temp folder
		$request->file('video')->move(storage_path(). '/uploads', $video->video_filename);

		// Upload to s3 Amazon
		$this->dispatch(new UploadVideo(
			$video->video_filename
		));

		return response()->json(null,200);
	}
}
