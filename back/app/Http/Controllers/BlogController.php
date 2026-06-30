<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Models\Category;
use TCG\Voyager\Models\Post;

class BlogController extends Controller
{
    public function blog(Request $request) 
    {
        if($request->category && $request->category != 'all') {
            $category = Category::whereSlug($request->category)->firstOrFail();
            $posts = Post::whereStatus('PUBLISHED')->where('category_id', $category->id)->orderBy('id','DESC')->paginate(10);
        } else {
            $posts = Post::whereStatus('PUBLISHED')->orderBy('id','DESC')->paginate(10);
        }

        $categories = Category::all();
        return view('blog.index', compact('posts', 'categories'));
    }

    public function blogDetails($slug, Request $request)
    {
        $post = Post::whereSlug($slug)->firstOrFail();
        $categories = Category::all();
        $category_name = '';
        $category_link = '';
        if($post->category_id) {
            $category_res = Category::whereId($post->category_id)->first();
            if($category_res) {
                $category_name = $category_res->name;
                $category_link = url('posts?category=' . $category_res->slug);
            }
        }
        $posts = Post::whereStatus('PUBLISHED')->where('category_id', 3)->orderBy('id', 'DESC')->limit(2)->get();
        return view('blog.detail', compact('posts', 'post', 'categories', 'category_name', 'category_link'));
    }
}
