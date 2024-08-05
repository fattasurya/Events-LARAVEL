<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

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
        $event->delete();
        return redirect()->route('events.list')->with('success', 'Event successfully deleted');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'description' => 'required',
            'room' => 'required',
            'shirt' => 'required'
        ]);
    
        // Cek apakah ada acara lain dengan room yang sama pada tanggal yang sama
        $conflict = Event::where('room', $request->room)
            ->where(function ($query) use ($request) {
                // Memeriksa apakah acara lain terjadi pada tanggal yang sama
                $query->where(function ($q) use ($request) {
                    $q->whereBetween('start', [$request->start, $request->end])
                      ->orWhereBetween('end', [$request->start, $request->end]);
                })
                ->orWhere(function ($q) use ($request) {
                    $q->where('start', '<=', $request->start)
                      ->where('end', '>=', $request->end);
                });
            })
            ->exists();
    
        if ($conflict) {
            return response()->json(['message' => 'The selected room is already booked for the chosen time period.'], 400);
        }
    
        // Simpan acara baru
        $event = Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'description' => $request->description,
            'room' => $request->room,
            'shirt' => $request->shirt,
        ]);
    
        return response()->json($event, 201); // 201 Created
    }
    
    
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'room' => 'required',
            'description' => 'required',
            'shirt' => 'required'
        ]);
    
        // Cek apakah ada acara lain dengan room yang sama (kecuali acara saat ini) pada tanggal yang sama
        $conflict = Event::where('room', $request->room)
            ->where(function ($query) use ($request) {
                // Memeriksa apakah acara lain terjadi pada tanggal yang sama
                $query->whereBetween('start', [$request->start, $request->end])
                    ->orWhereBetween('end', [$request->start, $request->end])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start', '<=', $request->start)
                              ->where('end', '>=', $request->end);
                    });
            })
            ->where('id', '!=', $id)
            ->exists();
    
        if ($conflict) {
            return response()->json(['message' => 'The selected room is already booked for the chosen time period.'], 400);
        }
    
        // Temukan acara yang akan diperbarui dan perbarui
        $event = Event::find($id);
        $event->update($request->all());
    
        return response()->json($event);
    }
    

        

}