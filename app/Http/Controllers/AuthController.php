<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserMember;

class AuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ], [
    //         'email.required' => 'Email is required',
    //         'email.email' => 'Please enter a valid email address',
    //         'password.required' => 'Password is required',
    //     ]);
    
    //     // Periksa apakah pengguna ada di database
    //     $user = UserMember::where('email', $credentials['email'])->first();
    //     if (!$user) {
    //         return back()->withErrors(['email' => 'Invalid credentials. Please check your email and password.']);
    //     }
    
    //     // Periksa apakah password cocok
    //     if (!Hash::check($credentials['password'], $user->password)) {
    //         return back()->withErrors(['email' => 'Invalid credentials. Please check your email and password.']);
    //     }
    
    //     // Lakukan login
    //     Auth::login($user);
    
    //     if ($user->role === 'admin') {
    //         return redirect()->route('admin.dashboard.index');
    //     } elseif ($user->role === 'member') {
    //         return redirect()->route('member.landingpage.index');
    //     }
    
    //     return back()->withErrors(['email' => 'Invalid credentials. Please check your email and password.']);
    // }  
    
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
        ]);
    
        // Lakukan proses login
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
    
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard.index');
            } elseif ($user->role === 'member') {
                return redirect()->route('member.landingpage.index');
            }
        }
    
        // Jika login gagal, kembalikan dengan pesan kesalahan
        return back()->withErrors(['email' => 'Invalid credentials. Please check your email and password.']);
    }    

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = UserMember::create([
            'nama' => $validatedData['nama'],
            'telepon' => $validatedData['telepon'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login to continue.');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
