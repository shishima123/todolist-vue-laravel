<?php

namespace App\Http\Controllers;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        return view('index');
    }
}
