<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

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
        $blog = Blog::where('slug', $slug)->first();
        $heads = $this->headers($blog->description);
        $blogCategories = Category::all();
        $latestBlog = Blog::latest()->get();
        return view('blog.detail', compact('blog', 'heads', 'blogCategories', 'latestBlog'));
    }

    public function category($category)
    {
        $blogCategories = Category::where('slug', $category)->get();
        return view('blog.index', compact('blogCategories'));
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
