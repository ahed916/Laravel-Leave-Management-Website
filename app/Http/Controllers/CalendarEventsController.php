<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class CalendarEventsController extends Controller
{
    public function admin(Request $request){
        $leaves = Leave::with('user:id,name')
            ->select('id','user_id','type','start_date','end_date','status')
            ->get();
            $events = $leaves->map(function ($leave) {
                return [
                    'id'    => $leave->id,
                    'title' => "{$leave->user->name} — " . ucfirst($leave->type),
                    'start' => $leave->start_date->toDateString(),
                    'end'   => $leave->end_date->copy()->addDay()->toDateString(),
                    'allDay' => true,
                    'color' => match ($leave->status) {
                        'approved' => '#a5b4fc',
                        'pending'  => 'rgba(156, 163, 175, 0.7)',
                        default    => '#7c3aed',
                    },
                    'textColor' => '#111827',
                    'extendedProps' => [
                        'status' => $leave->status,
                        'type'   => $leave->type,
                    ],
                ];
            });
    
            return response()->json($events);
    }
    public function staff (Request $request){
        $userId = $request->user()->id;
        $leaves = Leave::where('user_id', $userId)
            ->where('status', 'approved')
            ->select('id','type','start_date','end_date','status')
            ->get();
        $events = $leaves->map(function ($leave) {
            return [
                'id'    => $leave->id,
                'title' => ucfirst($leave->type),
                'start' => $leave->start_date->toDateString(),
                'end'   => $leave->end_date->copy()->addDay()->toDateString(),
                'allDay' => true,
                'color' => '#a5b4fc', 
                'textColor' => '#111827',
                'extendedProps' => [
                    'status' => $leave->status,
                    'type'   => $leave->type,
                ],
            ];
        });

        return response()->json($events);
    }
}
