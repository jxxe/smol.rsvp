<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashController extends Controller
{
    public function index()
    {
        return Inertia::render('Dash', [
            'invitations' => auth()->user()->invitations()
                ->latest()->select(['title', 'slug', 'hex_color', 'views'])->get()
        ]);
    }
}
