<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpotPemancingan;
use App\Models\SewaPemancingan;
use App\Models\Galeri;
use App\Models\Blog;
use App\Models\AlatPancing;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class MemberLandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $images = Galeri::orderBy('created_at', 'desc')->paginate(3);
        $blogs = Blog::latest()->paginate(3);
        $alatPancing = AlatPancing::orderBy('created_at', 'desc')->paginate(6);

        // Mendapatkan data cuaca
        $city = 'Malangjiwan';
        $apiKey = env('OPENWEATHERMAP_API_KEY');
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

        $response = Http::get($url);
        $weatherData = $response->json();

        if ($response->successful()) {
            $weather = [
                'city' => $weatherData['name'],
                'description' => $weatherData['weather'][0]['description'],
                'temp' => $weatherData['main']['temp'],
                'feels_like' => $weatherData['main']['feels_like'],
                'humidity' => $weatherData['main']['humidity'],
                'wind_speed' => $weatherData['wind']['speed'],
            ];
        } else {
            $weather = null;
        }

        return view('Member.LandingPage.index', compact(['images', 'blogs', 'alatPancing', 'weather']));
    }

}
