<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('blogs.index', compact('blogs'));
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
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'body' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        $blog = new Blog();
        $blog->judul = $validated['judul'];
        $blog->slug = Str::slug($validated['judul']); // Use Str::slug directly without \
        $blog->kategori = $validated['kategori'];
        $blog->image = $imagePath;
        $blog->body = $validated['body'];
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
            $blog->image = $imagePath;
        }

        $blog->judul = $validated['judul'];
        $blog->slug = Str::slug($validated['judul']); // Use Str::slug directly without \
        $blog->kategori = $validated['kategori'];
        $blog->body = $validated['body'];
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog berhasil dihapus.');
    }
}