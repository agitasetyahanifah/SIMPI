<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(25);
        $lastItem = $blogs->lastItem();
        return view('admin.blog.index', compact('blogs','lastItem'));
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'body' => 'required|string',
        ]);

        $imagePath = $request->file('image')->store('uploads', 'public');

        $blog = new Blog();
        $blog->judul = $validated['judul'];
        $blog->slug = Str::slug($validated['judul']);
        $blog->kategori = $validated['kategori'];
        $blog->image = $imagePath;

        // Strip tags from body content
        $cleanedBody = strip_tags($validated['body']);

        $blog->body = $cleanedBody;
        $blog->save();

        return redirect()->back()->with('success', 'Blog berhasil ditambahkan.');
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
    public function destroy(String $id)
    {
        $blogs = Blog::findOrFail($id);

        // Hapus blog dari database
        $blogs->delete();

        // Redirect kembali ke halaman ddaftar blog dengan pesan sukses
        return redirect()->back()->with('success', 'Blog berhasil dihapus.');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Blog::class, 'slug', $request->judul);
        return response()->json(['slug' => $slug]);
    }
}