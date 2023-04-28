<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CalendarController extends Controller
{
    public function list()
    {
        $calendars = Http::withToken(auth()->user()->token())->get(
            'https://www.googleapis.com/calendar/v3/users/me/calendarList',
            ['minAccessRole' => 'writer']
        )->json('items');

        return collect($calendars)->map(function($calendar) {
            return [
                'id' => $calendar['id'],
                'title' => $calendar['summaryOverride'] ?? $calendar['summary']
            ];
        });
    }

    public function events()
    {
        if(!request()->has('calendar')) return response(status: 400);
        $calendarId = request()->get('calendar');

        $events = Http::withToken(auth()->user()->token())->get(
            "https://www.googleapis.com/calendar/v3/calendars/$calendarId/events",
            [
                'maxResults' => 50,
                'timeMin' => now()->format('c'),
                'maxAttendees' => 1
            ]
        )->json('items');

        return collect($events)
            ->filter(function($event) {
                    // Who the fuck knows
                    if(!key_exists('start', $event) || !key_exists('end', $event)) return false;

                    // Remove events that haven't been confirmed
                    if($event['status'] !== 'confirmed') return false;

                    // If should be able to add event to RSVP
                    if($event['creator']['self'] ?? false) return true;
                    if($event['organizer']['self'] ?? false) return true;

                    return false;
                })
            ->map(function($event) {
                    // Events will have `date` if all day and `dateTime` otherwise
                    $event['start']['date'] = new DateTime($event['start']['dateTime'] ?? $event['start']['date']);
                    $event['end']['date'] = new DateTime($event['end']['dateTime'] ?? $event['end']['date']);
                    return $event;
                })
            ->sort(function($a, $b) {
                    // Sort events nearest to furthest future
                    return $a['start']['date'] > $b['start']['date'];
                })
            ->map(function($event) {
                    return [
                        'id' => $event['id'],
                        'title' => $event['summary'],
                        'date' => empty($event['recurrence']) ? $event['start']['date']->format('M j') : 'Recurring'
                    ];
                })
            ->values();
    }
}
