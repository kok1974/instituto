<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function store(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $path = $request->file('avatar')->store('avatars');
        $user->avatar = $path;
        $user->save();
        return response()->json($user);
    }

    public function getAvatar()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return Storage::get($user->avatar);
    }
}
