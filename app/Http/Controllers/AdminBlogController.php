<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\KategoriBlog;
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
        $kategoriBlog = KategoriBlog::orderByDesc('created_at')->paginate(5);
        $lastItem2 = $kategoriBlog->lastItem();
        $kategoriOpt = KategoriBlog::all();
        return view('admin.blog.index', compact('blogs','lastItem','lastItem2','kategoriBlog','kategoriOpt'));
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
            'kategori_blog' => 'required|exists:kategori_blog,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'body' => 'required|string',
        ]);

        // Menyimpan foto ke dalam direktori public/images
        $imageFileName = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $imageFileName);

        $blog = new Blog();
        $blog->judul = $validated['judul'];
        $blog->slug = Str::slug($validated['judul']);
        $blog->kategori_id = $validated['kategori_blog'];
        $blog->image = $imageFileName;
        $blog->body = $validated['body'];
        $blog->save();

        return redirect()->back()->with('success', 'Blog added successfully.');
    }

    public function storeKategori(Request $request)
    {
        $validated = $request->validate([
            'kategori_blog' => 'required',
        ]);

        $kategoriBlog = new KategoriBlog();
        $kategoriBlog->kategori_blog = $validated['kategori_blog'];
        $kategoriBlog->save();

        return redirect()->back()->with('success', 'Blog category added successfully.');
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
            'kategori_blog' => 'required|exists:kategori_blog,id',
            'body' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // hapus foto lama
            if($blog->image){
                unlink(public_path('images/' . $blog->image));
            }

            // simpan foto baru
            $image = $request->file('image');
            $nameImage = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/'), $nameImage);

            $blog->image = $nameImage;
        }

        $blog->judul = $validated['judul'];
        $blog->slug = Str::slug($validated['judul']); // Use Str::slug directly without \
        $blog->kategori_id = $validated['kategori_blog'];
        $blog->body = $validated['body'];
        $blog->save();

        return redirect()->back()->with('success', 'Blog updated successfully.');
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
        return redirect()->back()->with('success', 'Blog successfully deleted.');
    }

    public function deleteKategori(String $id)
    {
        $kategoriBlog = KategoriBlog::findOrFail($id);
    
        // Hapus semua blog yang terkait dengan kategori ini
        Blog::where('kategori_id', $kategoriBlog->id)->delete();
    
        // Hapus kategori dari database
        $kategoriBlog->delete();
    
        // Redirect kembali ke halaman daftar kategori blog dengan pesan sukses
        return redirect()->back()->with('success', 'The blog category and related blogs have been successfully deleted.');
    }    

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Blog::class, 'slug', $request->judul);
        return response()->json(['slug' => $slug]);
    }
}