<?php

namespace App\Http\Controllers;

use App\Models\SubUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $subUsers = SubUser::where('main_user_id', $user->id)->get();

        return view('subusers.index', compact('user', 'subUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subusers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nickname' => ['required', 'string', 'max:20'],
            'user_image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], //引越予定日
        ]);

        $user = Auth::user();

        $subUser = new SubUser();
        $subUser->main_user_id = $user->id;
        $subUser->nickname = $request->input('nickname');

        if ($request->hasFile('user_image_path')) {
            $path = $request->file('user_image_path')->store('subusers', 'public');
            $subUser->user_image_path = $path;
        }

        $subUser->save();

        return redirect()->route('subusers.index')->with('success', 'サブユーザーを登録しました');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubUser  $subUser
     * @return \Illuminate\Http\Response
     */
    public function edit(SubUser $subUser)
    {
        return view('subusers.edit', compact('subUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubUser  $subUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubUser $subUser)
    {
        $request->validate([
            'nickname' => ['required', 'string', 'max:20'],
            'user_image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], //引越予定日
        ]);

        $subUser->nickname = $request->input('nickname');

        if ($request->hasFile('user_image_path')) {
            // 古い画像を削除する処理が必要ならここに追加
            if ($subUser->user_image_path && Storage::exists('public/' . $subUser->user_image_path)) {
                Storage::delete('public/' . $subUser->user_image_path);
            }

            $path = $request->file('user_image_path')->store('subusers', 'public');
            $subUser->user_image_path = $path;
        }

        $subUser->save();

        return redirect()->route('subusers.index')->with('success', 'サブユーザーを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubUser  $subUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubUser $subUser)
    {
        if ($subUser->user_image_path && Storage::exists('public/' . $subUser->user_image_path)) {
            Storage::delete('public/' . $subUser->user_image_path);
        }

        $name = $subUser->nickname;
        $subUser->delete();

        return redirect()->route('subusers.index')->with('success', $name . 'さんを削除しました。');
    }
}
