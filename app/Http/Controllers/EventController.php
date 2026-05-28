<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('user_id', auth()->id());

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $events = $query->get();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'event_type' => 'required',
        'event_date' => 'required',
        'location' => 'required',
        'budget' => 'required|numeric',
        'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    /*
    |--------------------------------------------------------------------------
    | File Upload
    |--------------------------------------------------------------------------
    */

    $bannerPath = null;

    if ($request->hasFile('banner')) {

        $bannerPath = $request->file('banner')
            ->store('events', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | Create Event
    |--------------------------------------------------------------------------
    */

    Event::create([

        'user_id' => auth()->id(),

        'title' => $request->title,

        'event_type' => $request->event_type,

        'event_date' => $request->event_date,

        'location' => $request->location,

        'budget' => (float) $request->budget,

        'description' => $request->description,

        'status' => 'Upcoming',

        'banner' => $bannerPath

    ]);

    return redirect()
        ->route('events.index')
        ->with('success', 'Event Created Successfully');
}

    public function show(string $id)
    {
        $event = Event::findOrFail($id);

        return view('events.show', compact('event'));
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, string $id)
{
    $event = Event::findOrFail($id);

    $request->validate([
        'title' => 'required',
        'event_type' => 'required',
        'event_date' => 'required',
        'location' => 'required',
        'budget' => 'required|numeric',
        'banner' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Replace Banner
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('banner')) {

        /*
        |--------------------------------------------------------------------------
        | Delete Old Image
        |--------------------------------------------------------------------------
        */

        if ($event->banner) {

            Storage::disk('public')
                ->delete($event->banner);
        }

        /*
        |--------------------------------------------------------------------------
        | Upload New Image
        |--------------------------------------------------------------------------
        */

        $bannerPath = $request->file('banner')
            ->store('events', 'public');

        $event->banner = $bannerPath;
    }

    /*
    |--------------------------------------------------------------------------
    | Update Fields
    |--------------------------------------------------------------------------
    */

    $event->title = $request->title;

    $event->event_type = $request->event_type;

    $event->event_date = $request->event_date;

    $event->location = $request->location;

    $event->budget = (float) $request->budget;

    $event->description = $request->description;

    $event->save();

    return redirect()
        ->route('events.index')
        ->with('success', 'Event Updated Successfully');
}

    public function destroy(string $id)
{
    $event = Event::findOrFail($id);

    /*
    |--------------------------------------------------------------------------
    | Delete Banner
    |--------------------------------------------------------------------------
    */

    if ($event->banner) {

        Storage::disk('public')
            ->delete($event->banner);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Event
    |--------------------------------------------------------------------------
    */

    $event->delete();

    return redirect()
        ->route('events.index');
}
}