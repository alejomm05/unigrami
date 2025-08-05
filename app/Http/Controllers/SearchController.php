<?php

// app/Http/Controllers/SearchController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (strlen($query) < 2) {
            return response()->json(['users' => []]);
        }

        $users = User::where('username', 'like', "%{$query}%")
            ->orWhere('display_name', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json(['users' => $users]);
    }
}
