<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    public function showMediaImage(Filesystem $filesystem, $year, $month, $file_name)
    {

        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => public_path('/')."uploads/media_library/$year/$month/",
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'img',
        ]);

        $server->outputImage(
            $file_name,
            [
                'w' => request()->get('w'),
                'h' => request()->get('h'),
                'fit' => request()->get('fit', 'crop'),
                'filt' => request()->get('filt'),
                'fm' => 'pjpg'
            ]
        );
    }

    public function showAssetImage(Filesystem $filesystem, $file_name)
    {

        $server = ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => public_path('/')."assets/img/",
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => '.cache',
            'base_url' => 'img',
        ]);

        $server->outputImage(
            $file_name,
            [
                'w' => request()->get('w'),
                'h' => request()->get('h'),
                'fit' => request()->get('fit', 'crop'),
                'filt' => request()->get('filt'),
                'fm' => 'pjpg'
            ]
        );
    }
}
