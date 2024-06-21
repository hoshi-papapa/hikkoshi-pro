<?php

namespace App\Http\Controllers;

use App\Models\TemplateTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() //テンプレートタスクを一覧表示する必要はないのでテスト
    {
        $templateTasks = TemplateTask::all();

        return view('templatetasks.index', compact('templateTasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TemplateTask  $templateTask
     * @return \Illuminate\Http\Response
     */
    public function show(TemplateTask $templateTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TemplateTask  $templateTask
     * @return \Illuminate\Http\Response
     */
    public function edit(TemplateTask $templateTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TemplateTask  $templateTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TemplateTask $templateTask)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TemplateTask  $templateTask
     * @return \Illuminate\Http\Response
     */
    public function destroy(TemplateTask $templateTask)
    {
        //
    }
}
