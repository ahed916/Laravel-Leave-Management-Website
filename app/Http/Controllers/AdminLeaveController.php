<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;
use App\Mail\LeaveStatusUpdated;
use Illuminate\Support\Facades\Mail;

class AdminLeaveController extends Controller
{
    public function index(){
        $leaves = Leave::where('status', 'pending')->with('user')->paginate(10);
        return view('admin.leavesIndex', compact('leaves'));
    }
    public function approve($id){
        $leave = Leave::findOrFail($id);
        $leave->status = 'approved';
        $leave->save();
        Mail::to($leave->user->email)->send(new LeaveStatusUpdated($leave));
        return redirect()->back()->with('success', 'Leave request approved.');
    }
    public function reject($id){
        $leave = Leave::findOrFail($id);
        $leave->status = 'rejected';
        $leave->save();
        Mail::to($leave->user->email)->send(new LeaveStatusUpdated($leave));
        return redirect()->back()->with('error', 'Leave request rejected.');
    }
}
