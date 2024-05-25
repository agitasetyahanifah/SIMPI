<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\KategoriBlog;

class MemberBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(12);
        $lastItem = $blogs->lastItem();
        return view('guest.blog.blog', compact('blogs','lastItem'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data blog berdasarkan ID
        $blog = Blog::findOrFail($id);
    
        // Mengambil 6 blog terbaru, selain blog yang sedang ditampilkan
        $latestBlogs = Blog::where('id', '!=', $id)->latest()->take(3)->get();

        $kategoriBlog = KategoriBlog::orderByDesc('created_at')->paginate(5);
    
        // Mengembalikan view dengan data blog dan latestBlogs
        return view('guest.blog.detail-blog', compact('blog', 'latestBlogs', 'kategoriBlog'));
    } 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
