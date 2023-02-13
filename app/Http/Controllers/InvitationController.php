<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class InvitationController extends Controller
{
    public function show(Invitation $invitation)
    {
        $invitation->views++;
        $invitation->save();

        return Inertia::render('Invitation', [
            'invitation' => $invitation->only(
                'title',
                'image_url',
                'logo_url',
                'redirect_url',
                'email_domain',
                'description',
                'slug'
            )
        ]);
    }

    public function accept()
    {
        $invitation = Invitation::where('slug', request('invitation'))->first();

        if($invitation === null) return response(status: 400);
        if(request('email') && $invitation->email_domain) response(status: 401);
        if(request('email_part') && !$invitation->email_domain) response(status: 402);

        if($invitation->email_domain) $email = request('email_part') . '@' . $invitation->email_domain;
        else $email = request('email');
    }

    public function destroy(Invitation $invitation)
    {
        if($invitation->user_id === auth()->user()->id) {
            $invitation->delete();
            Storage::delete([$invitation->logo_url, $invitation->image_url]);
        }
    }
    
    public function store()
    {
        $data = request()->validate([
            'title' => 'string|required',
            'description' => 'string|nullable',
            'calendar_id' => 'string|required',
            'event_id' => 'string|required',
            'email_domain' => 'string|regex:/^[a-z0-9]+\.[a-z]{2,}$/i|nullable',
            'logo' => ['file', 'nullable', File::image()->max(2 * 1024)],
            'image' => ['file', 'nullable', File::image()->max(5 * 1024)],
            'redirect_url' => 'url|nullable'
        ]);

        $data['slug'] = Str::slug($data['title'] . ' ' . Str::random(6));
        unset($data['logo'], $data['image']);

        if(request()->hasFile('logo')) {
            $data['logo_url'] = request()->file('logo')->storePublicly('uploads');
        }

        if(request()->hasFile('image')) {
            $data['image_url'] = request()->file('image')->storePublicly('uploads');
        }

        auth()->user()->invitations()->create($data);
    }
}
