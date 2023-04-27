<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;

class InvitationController extends Controller
{
    public function show(Invitation $invitation)
    {
        $logo = $invitation->logo()->first();

        return Inertia::render('Invitation', [
            'invitation' => [
                'slug' => $invitation->slug,
                'title' => $invitation->title,
                'description' => $invitation->description,
                'email_domain' => $invitation->email_domain,
                'image_url' => $invitation->image_url,
                'redirect_url' => $invitation->redirect_url,
                'custom_color' => $invitation->custom_color,
                'logo' => $logo ? [
                    'src' => $logo->image_url,
                    'width' => $logo->width,
                    'height' => $logo->height,
                ] : null
            ]
        ]);
    }

    public function accept()
    {
        $invitation = Invitation::where('slug', request('invitation'))->first();

        if($invitation === null) return response('Invitation not found', 400);
        if(request('email') && $invitation->email_domain) response(status: 400);
        if(request('email_part') && !$invitation->email_domain) response(status: 400);

        if($invitation->email_domain) $email = request('email_part') . '@' . $invitation->email_domain;
        else $email = request('email');

        $event = Http::withToken(auth()->user()->token())->get(
            "https://www.googleapis.com/calendar/v3/calendars/$invitation->calendar_id/events/$invitation->event_id"
        )->json();

        $event['attendees'] = $event['attendees'] ?? [];
        $event['attendees'][] = [
            'email' => $email,
            'responseStatus' => 'accepted' // needsAction
        ];

        Http::withToken(auth()->user()->token())->put(
            "https://www.googleapis.com/calendar/v3/calendars/$invitation->calendar_id/events/$invitation->event_id?sendUpdates=all",
            $event
        );

        $invitation->rsvps++;
        $invitation->save();
    }

    public function destroy(Invitation $invitation)
    {
        if($invitation->user_id === auth()->user()->id) {
            if($invitation->image_url) Storage::delete($invitation->image_url);
            $invitation->delete();
        } else return response(status: 400);
    }

    public function update(Invitation $invitation)
    {
        if($invitation->user_id === auth()->user()->id) {
            $data = request()->validate([
                'title' => 'string|required',
                'description' => 'string|nullable',
                'email_domain' => 'string|regex:/^[a-z0-9]+\.[a-z]{2,}$/i|nullable',
                'logo_id' => 'integer|nullable',
                'image' => ['file', 'nullable', File::image()->max(5 * 1024)],
                'redirect_url' => 'url|nullable',
                'image_url' => 'nullable',
                'custom_color' => 'nullable|regex:/#[0-9A-f]{6}/'
            ]);

            if($data['image_url'] !== null) {
                unset($data['image_url']);
            }

            unset($data['image']);

            if(request()->hasFile('image')) {
                if($invitation->image_url) Storage::delete($invitation->image_url);
                $data['image_url'] = request()->file('image')->storePublicly('uploads');
            }
    
            $invitation->update($data);
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
            'logo_id' => 'integer|nullable',
            'image' => ['file', 'nullable', File::image()->max(5 * 1024)],
            'redirect_url' => 'url|nullable',
            'custom_color' => 'nullable|regex:/#[0-9A-f]{6}/'
        ]);

        $data['slug'] = Str::slug($data['title'] . ' ' . Str::random(6));

        unset($data['image']);

        if(request()->hasFile('image')) {
            $data['image_url'] = request()->file('image')->storePublicly('uploads');
        }

        auth()->user()->invitations()->create($data);
    }
}
