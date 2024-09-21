<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TasksController extends Controller
{
    /**
     * TasksController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return RedirectResponse|View
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        return view('todos.list.index');
    }

}
