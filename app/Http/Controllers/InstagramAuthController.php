<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dymantic\InstagramFeed\Profile;

class InstagramAuthController extends Controller
{
    public function show() {
        $profile = Profile::where('username', 'your_username')->first();
        return view('instagram-auth', ['instagram_auth_url' => $profile->getInstagramAuthUrl()]);
    }

    public function callback() {
        // Handle the callback from Instagram
    }

    public function response() {
        $was_successful = request('result') === 'success';
        return view('instagram-auth-response', ['was_successful' => $was_successful]);
    }
}
