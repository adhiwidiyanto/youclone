<?php

namespace App\Jobs;

use File;
use Image;
use Storage;
use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadImage implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $channel;

    public $fileId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get images
        $path = storage_path() . '/uploads/' . $this->fileId;
        $fileName = $this->fileId . '.png';

        // Resize image 
        Image::make($path)->encode('png')->fit(40,40, function ($c){
            $c->upsize();
        })->save();

        // Uploads to S3 and delete temporary file after upload to S3
        if (Storage::disk('s3images')->put('profile/' . $fileName, fopen($path, 'r+'))) {
            File::delete('path');
        }


        // Update Channel Image filename
        $this->channel->update([
            'image_filename' => $fileName
        ]);
    }
}
