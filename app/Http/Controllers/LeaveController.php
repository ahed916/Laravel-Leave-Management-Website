<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Mail\LeaveSubmittedToAdmin;
use Illuminate\Support\Facades\Mail;

class LeaveController extends Controller
{
    public function index(){
        $leaves = Leave::where('user_id', auth()->id())->paginate(10);
        return view('staff.index', compact('leaves'));
    }

    public function create(){
        $admins = User::admins()->select('id','name')->orderBy('name')->get();
        return view('staff.create',compact('admins'));
    }

    public function store(Request $request) {
        $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'comment' => 'nullable|string',
            'admin_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where(fn($q) => $q->where('is_admin', 1)),
            ],
        ]);
        $leave=Leave::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'comment' => $request->comment,
            'status' => 'pending',
            'admin_id' => $request->admin_id,
        ]);
        Mail::to($leave->admin->email)->send(new LeaveSubmittedToAdmin($leave));
        return redirect()->route('leaves.index')->with('success', 'Leave request submitted.');
    }

    public function edit($id){
        $leave = Leave::findOrFail($id);
        return view('staff.edit', compact('leave'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'comment' => 'nullable|string',
        ]);
        $leave = Leave::findOrFail($id);
        $leave->type = $request->type;
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->comment = $request->comment;
        $leave->save();
    return redirect()->route('leaves.index')->with('success', 'Leave Request updated successfully.');
    }
    public function delete($id){
        Leave::findOrFail($id)->delete();
        return back()->with('success', 'Leave Request deleted successfully.');
    }



    

}