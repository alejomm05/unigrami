<?php

// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); 
    return view('profile.edit', compact('user'));
    }

  public function update(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $request->validate([
        'display_name'  => 'required|string|max:255',
        'email'         => 'required|email|unique:users,email,' . $user->id,
        'profile_image' => 'nullable|image|max:2048',
    ]);

    $user->display_name = $request->display_name;
    $user->email        = $request->email;

    if ($request->hasFile('profile_image')) {
        // 1. Solo borrar si existe ruta y el archivo está presente
        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // 2. Guardar la nueva imagen (devuelve 'profiles/archivo.jpg')
        $user->profile_image = $request->file('profile_image')
                                   ->store('profiles', 'public');
    }

    $user->save();

    return back()->with('status', 'Perfil actualizado correctamente.');
}


      public function show(User $user)
    {
        $postsCount     = $user->posts()->count();
        $followersCount = $user->followers()->count();
        $followingCount = $user->follows()->count();
        $posts          = $user->posts()->latest()->get();

        return view('profile.show', compact(
            'user',
            'postsCount',
            'followersCount',
            'followingCount',
            'posts'
        ));
    }
}