<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashController extends Controller
{
    public function index()
    {
        return Inertia::render('Dash', [
            'invitations' => auth()->user()->invitations()->latest()->get()
        ]);
    }
}
