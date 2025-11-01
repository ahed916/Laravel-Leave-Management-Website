<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Leave;
use Illuminate\Http\Request;
use App\Exports\LeavesExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminDashboardController extends Controller {

    public function index(Request $request){
        $totalEmployees = User::where('is_admin', 0)->count();
        $pendingRequests = Leave::where('status', 'pending')->count();
        $approvedRequests = Leave::where('status', 'approved')->count();
        $rejectedRequests = Leave::where('status', 'rejected')->count();
        $leaves = Leave::query(); //query for leave requests
        //if picked filteres 
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $leaves->whereBetween('start_date', [$request->date_from, $request->date_to]);
        }
        if ($request->filled('user_id')) {
            $leaves->where('user_id', $request->user_id);
        }
        if ($request->filled('leave_type')) {
            $leaves->where('type', $request->leave_type);
        }
        if ($request->filled('leave_status')) {
            $leaves->where('status', $request->leave_status);
        }
        $leaves = $leaves->with('user')->latest()->paginate(10); //get the leave + their user info
        $users = User::where('is_admin', 0)->get();
        return view('admin.dashboard', compact(
        'totalEmployees',
        'pendingRequests',
        'approvedRequests',
        'rejectedRequests',
        'leaves',
        'users' 
    ));
}

    public function exportcsv(Request $request) {
        $query = Leave::with('user'); //query for leaves export aith user info
        //if filters applied
        if ($request->filled('date_from')) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('end_date', '<=', $request->date_to);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('leave_type')) {
            $query->where('type', $request->leave_type);
        }
        if ($request->filled('leave_status')) {
            $leaves->where('status', $request->leave_status);
        }





    return Excel::download(new LeavesExport($query), 'leaveRequests.csv', \Maatwebsite\Excel\Excel::CSV);
}


public function exportPDF(Request $request) {

    $query = Leave::with('user');
    if ($request->filled('date_from')) {
        $query->whereDate('start_date', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->whereDate('end_date', '<=', $request->date_to);
    }
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }
    if ($request->filled('leave_type')) {
        $query->where('type', $request->leave_type);
    }
    if ($request->filled('leave_status')) {
        $leaves->where('status', $request->leave_status);
    }

    $leaveRequests = $query->get();
    $pdf = PDF::loadView('admin.exports.leaves-pdf', [
        'leaveRequests' => $leaveRequests,
        'date' => now()->format('d/m/Y'),
    ]);

    
    
    return $pdf->download('leave-requests.pdf');
}



}
