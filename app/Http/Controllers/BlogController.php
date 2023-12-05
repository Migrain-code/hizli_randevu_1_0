<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BlogController extends Controller
{
    public function index()
    {
        $blogCategories = Category::all();
        $ads = Ads::where('type', 4)->where('status', 1)->get();
        return view('blog.index', compact('blogCategories', 'ads'));
    }

    public function detail($slug)
    {
        $blog = Blog::whereJsonContains('slug->' . App::getLocale(), $slug)->first();
        if ($blog) {
            $heads = $this->headers($blog->descriptions);
            $blogCategories = Category::all();
            $latestBlog = Blog::latest()->get();
            return view('blog.detail', compact('blog', 'heads', 'blogCategories', 'latestBlog'));
        } else {
            return back()->with('response', [
               'status' => "warning",
               'message' => "Blog bulunamadı"
            ]);
        }

    }

    public function category($category)
    {
        $blogCategories = Category::whereJsonContains('slug->' . App::getLocale(), $category)->get();
        if ($blogCategories->count() > 0){
            $ads = Ads::where('type', 4)->where('status', 1)->get();
            return view('blog.index', compact('blogCategories', 'ads'));
        } else {
            return back()->with('response', [
                'status' => "warning",
                'message' => "Blog bulunamadı"
            ]);
        }

    }

    public function headers($html)
    {
        $heads = [];
        preg_match_all('/<h[1-5].*?>(.*?)<\/h[1-5]>/', $html, $matches);
        foreach ($matches[1] as $match) {
            $heads[] = $match;
        }
        return $heads;
    }

}
