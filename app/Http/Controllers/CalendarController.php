<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

        return collect($events)->filter(function($event) {
            return ($event['creator']['self'] ?? false) || ($event['organizer']['self'] ?? false);
        })->sort(function($a, $b) {
            return strtotime($a['start']['dateTime']) - strtotime($b['start']['dateTime']);
        })->map(function($event) {
            return [
                'id' => $event['id'],
                'title' => $event['summary'],
                'date' => empty($event['recurrence']) ? Carbon::createFromTimeString($event['start']['dateTime'])->format('M j') : 'Recurring'
            ];
        })->values();
    }
}
