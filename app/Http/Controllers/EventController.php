<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function list()
    {
        $events = Event::all();
        return view('events.list', compact('events'));
    }
    public function listadmin()
    {
        $events = Event::all();
        return view('events.listadmin', compact('events'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $events = Event::where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhere('room', 'like', "%$query%")
            ->orWhere('shirt', 'like', "%$query%")
            ->get();

        return view('events.list', ['events' => $events]);
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        if ($event->image && Storage::exists('public/images/' . $event->image)) {
            Storage::delete('public/images/' . $event->image);
        }

        $event->delete();

        return response()->json(['success' => true, 'message' => 'Event deleted successfully']);
    }



    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'description' => 'nullable',
            'room' => 'nullable',
            'shirt' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $start = $request->input('start');
        $end = $request->input('end');
        $room = $request->input('room');

        // Check for overlapping events in the same room
        $conflictingEvent = Event::where('room', $room)
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start', [$start, $end])
                    ->orWhereBetween('end', [$start, $end])
                    ->orWhere(function ($query) use ($start, $end) {
                        $query->where('start', '<=', $start)
                            ->where('end', '>=', $end);
                    });
            })
            ->exists();

        if ($conflictingEvent) {
            return response()->json(['success' => false, 'message' => 'The room is already booked during the selected time.'], 400);
        }

        $event = new Event();
        $event->title = $request->title;
        $event->start = $start;
        $event->end = $end;
        $event->description = $request->description;
        $event->room = $room;
        $event->shirt = $request->shirt;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $event->image = $imageName;
        }

        $event->save();

        return response()->json($event);
    }



    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'description' => 'nullable|string',
            'room' => 'nullable|string',
            'shirt' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $start = $request->input('start');
        $end = $request->input('end');
        $room = $request->input('room');

        // Check for overlapping events in the same room, excluding the current event
        $conflictingEvent = Event::where('room', $room)
            ->where('id', '!=', $id) // Exclude the current event
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start', [$start, $end])
                    ->orWhereBetween('end', [$start, $end])
                    ->orWhere(function ($query) use ($start, $end) {
                        $query->where('start', '<=', $start)
                            ->where('end', '>=', $end);
                    });
            })
            ->exists();

        if ($conflictingEvent) {
            return response()->json(['success' => false, 'message' => 'The room is already booked during the selected time.'], 400);
        }

        $event->title = $request->input('title');
        $event->start = $start;
        $event->end = $end;
        $event->description = $request->input('description');
        $event->room = $room;
        $event->shirt = $request->input('shirt');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image && Storage::exists('public/images/' . $event->image)) {
                Storage::delete('public/images/' . $event->image);
            }

            // Store new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $event->image = $imageName;
        }

        $event->save();

        return response()->json(['success' => true, 'message' => 'Event updated successfully']);
    }

    public function todaysEvents()
    {
        $today = Carbon::today();
        $events = Event::whereDate('start', $today)->get();
        return response()->json($events);
    }

   












}
