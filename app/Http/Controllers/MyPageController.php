<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\User;

class MyPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('mypage.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('mypage.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'planned_moving_date' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->input('name');
        $user->planned_moving_date = $request->input('planned_moving_date');
        $user->phone_number = $request->input('phone_number');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();

        return redirect()->route('mypage.index')->with('success', 'ユーザー情報を更新しました。');
    }
}
