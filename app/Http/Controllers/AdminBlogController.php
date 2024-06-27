<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // Mengambil data blog, diurutkan berdasarkan tanggal pembuatan terbaru, dengan paginasi 25 item per halaman
        $blogs = Blog::latest()->paginate(25);
         // Mendapatkan item terakhir dari koleksi data blog yang dipaginasi
        $lastItem = $blogs->lastItem();
        // Mengambil data kategori blog, diurutkan berdasarkan tanggal pembuatan terbaru, dengan paginasi 5 item per halaman
        $kategoriBlog = KategoriBlog::orderByDesc('created_at')->paginate(5);
        $lastItem2 = $kategoriBlog->lastItem();
        // Mengambil semua data kategori blog
        $kategoriOpt = KategoriBlog::all();
        // Mengembalikan view 'admin.blog.index' dengan data 'blogs', 'lastItem', 'lastItem2', 'kategoriBlog', dan 'kategoriOpt'
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
        // Validasi input form untuk judul, kategori blog yang ada, gambar, dan isi blog
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_blog' => 'required|exists:kategori_blog,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'body' => 'required|string',
        ]);

        // Menyimpan foto ke dalam direktori public/images
        $imageFileName = $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images'), $imageFileName);

        // Simpan data blog baru ke dalam database
        $blog = new Blog();
        $blog->judul = $validated['judul'];
        $blog->slug = Str::slug($validated['judul']);
        $blog->kategori_id = $validated['kategori_blog'];
        $blog->user_id = Auth::id();
        $blog->image = $imageFileName;
        $blog->body = $validated['body'];
        $blog->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Blog added successfully.');
    }

    public function storeKategori(Request $request)
    {
        // Validasi input form untuk kategori blog yang diperlukan
        $validated = $request->validate([
            'kategori_blog' => 'required',
        ]);

        // Simpan kategori blog baru ke dalam database
        $kategoriBlog = new KategoriBlog();
        $kategoriBlog->kategori_blog = $validated['kategori_blog'];
        $kategoriBlog->user_id = Auth::id();
        $kategoriBlog->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
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
        // Validasi input form untuk judul, kategori blog yang ada, dan isi blog
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_blog' => 'required|exists:kategori_blog,id',
            'body' => 'required|string',
        ]);

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // hapus foto lama
            if($blog->image){
                unlink(public_path('images/' . $blog->image));
            }

            // simpan foto baru
            $image = $request->file('image');
            $nameImage = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/'), $nameImage);

            // Update nama file gambar di data blog
            $blog->image = $nameImage;
        }

        // Update data blog dengan nilai dari form
        $blog->judul = $validated['judul'];
        $blog->slug = Str::slug($validated['judul']);
        $blog->kategori_id = $validated['kategori_blog'];
        $blog->user_id = Auth::id();
        $blog->body = $validated['body'];
        $blog->save();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
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