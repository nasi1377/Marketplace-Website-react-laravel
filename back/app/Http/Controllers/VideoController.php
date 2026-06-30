<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function videos(Request $request)
    {
        $videos = Video::whereStatus('PUBLISHED')->orderBy('id', 'DESC')->paginate(10);
        return view('videos.index', compact('videos'));
    }

    public function videoDetails($slug, Request $request)
    {
        $video = Video::whereSlug($slug)->firstOrFail();
        return view('videos.detail', compact('video'));
    }
}
