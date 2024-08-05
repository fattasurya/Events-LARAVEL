<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FullCalenderController extends Controller
{
    /**
     * Display the calendar view.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::whereDate('start', '>=', $request->start)
                         ->whereDate('end', '<=', $request->end)
                         ->get(['id', 'title', 'start', 'end']);

            return response()->json($data);
        }

        return view('fullcalender');
    }

    /**
     * Handle AJAX requests for add, update, and delete operations.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax(Request $request)
    {
        $response = [];

        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end'   => $request->end,
                ]);
                $response = $event;
                break;

            case 'update':
                $event = Event::find($request->id);
                if ($event) {
                    $event->update([
                        'title' => $request->title,
                        'start' => $request->start,
                        'end'   => $request->end,
                    ]);
                    $response = $event;
                } else {
                    return response()->json(['error' => 'Event not found'], 404);
                }
                break;

            case 'delete':
                $event = Event::find($request->id);
                if ($event) {
                    $event->delete();
                    $response = ['success' => true];
                } else {
                    return response()->json(['error' => 'Event not found'], 404);
                }
                break;

            default:
                return response()->json(['error' => 'Invalid request type'], 400);
        }

        return response()->json($response);
    }
}
