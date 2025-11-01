@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')

<style>
    .table-sortable th:nth-child(4), //4th 
    .table-sortable th:nth-child(5) { //5th
        cursor: pointer;
    }

    .table-sortable .th-sort-asc::after {
        content: "\25b4"; /*ascending arrow icon*/
    }

    .table-sortable .th-sort-desc::after {
        content: "\25be";/*descending arrow icon*/
    }

    .table-sortable .th-sort-asc::after,
    .table-sortable .th-sort-desc::after {
        margin-left: 5px; /*space between text and arrow*/
    }

    .table-sortable .th-sort-asc,
    .table-sortable .th-sort-desc{
    background: rgba(0, 0, 0, 0.1);
    }
</style>
@if(session('success'))
    <div class="flex justify-center">
        <div id="successMessage" class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded shadow w-full max-w-md text-center">
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-5 lg:px-8 space-y-10">

        
        <h3 class="text-xl font-semibold text-gray-800">Leave Request Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-5 text-center">
                <div class="text-gray-500">Total Employees</div>
                <div class="text-3xl font-bold text-indigo-600">{{ $totalEmployees }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-5 text-center">
                <div class="text-gray-500">Pending Requests</div>
                <div class="text-3xl font-bold text-yellow-500">{{ $pendingRequests }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-5 text-center">
                <div class="text-gray-500">Approved Requests</div>
                <div class="text-3xl font-bold text-green-600">{{ $approvedRequests }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-5 text-center">
                <div class="text-gray-500">Rejected Requests</div>
                <div class="text-3xl font-bold text-red-600">{{ $rejectedRequests }}</div>
            </div>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">Calendar</h3>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.19/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/web-component@6.1.19/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.19/index.global.min.js'></script>
        <div class="calendar-container bg-white rounded-lg shadow p-6 mb-6">
            <full-calendar
                id="calendar"
                options='{
                    "initialView": "dayGridMonth",
                    "headerToolbar": {
                        "left": "prev,next today",
                        "center": "title",
                        "right": "dayGridMonth,dayGridWeek,dayGridDay"
                    },
                    "events": []
                }'
            ></full-calendar>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const calendar=document.getElementById('calendar');
                    //if you already set some options in the attribute, read them:
                    const baseOptions = calendar.getAttribute('options') ? JSON.parse(calendar.getAttribute('options')) : {};
                    //add the events feed URL for admin:
                    const options = Object.assign({}, baseOptions, {
                        events: "{{ route('calendar.events.admin') }}",
                        eventDisplay: 'block', 
                        navLinks: true,
                        firstDay: 1, //Monday
                        dayMaxEvents: true,
                        height: 700
                    });
                    calendar.options = options;
                });
                </script>
                
        </div>
        
        <style>
        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #374151;
        }
        
        .fc .fc-button {
            background-color: #4f46e5; 
            border: none;
            border-radius: 0.5rem;
            padding: 0.4rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #fff;
            transition: background-color 0.2s;
        }
        
        .fc .fc-button:hover {
            background-color: #4338ca; 
        }
        
       
        .fc .fc-day-today {
            background-color: #eef2ff ; 
        }
        
        .fc .fc-event {
            border-radius: 0.5rem;
            padding: 2px 6px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .fc .fc-event:hover {
            opacity: 0.9;
        }
        </style>

        <h3 class="text-xl font-semibold text-gray-800">Leave Requests History</h3>

     
        <div class="bg-white border border-gray-200 rounded-lg shadow p-6 space-y-6">

            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                  
                    <div>
                        <label for="date_from" class="block text-gray-700 font-medium mb-1">From Date</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                   
                    <div>
                        <label for="date_to" class="block text-gray-700 font-medium mb-1">To Date</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                 
                    <div>
                        <label for="user_id" class="block text-gray-700 font-medium mb-1">Staff</label>
                        <select name="user_id" id="user_id" class="w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    
                    <div>
                        <label for="leave_type" class="block text-gray-700 font-medium mb-1">Leave Type</label>
                        <select name="leave_type" id="leave_type" class="w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Types</option>
                            <option value="annual" @selected(request('leave_type') == 'annual')>Annual</option>
                            <option value="sick" @selected(request('leave_type') == 'sick')>Sick</option>
                            <option value="maternity" @selected(request('leave_type') == 'maternity')>Maternity</option>
                            <option value="unpaid" @selected(request('leave_type') == 'unpaid')>Unpaid</option>
                            <option value="other" @selected(request('leave_type') == 'other')>Other</option>
                        </select>
                    </div>
                    <div>
                        <label for="leave_status" class="block text-gray-700 font-medium mb-1">Leave Status</label>
                        <select name="leave_status" id="leave_status" class="w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">All Status</option>
                            <option value="pending" @selected(request('leave_status') == 'pending')>Pending</option>
                            <option value="approved" @selected(request('leave_status') == 'approved')>Approved</option>
                            <option value="rejected" @selected(request('leave_status') == 'rejected')>Rejected</option>
                           
                        </select>
                    </div>
                </div>

                <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Filter
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">
                            Reset
                        </a>
                    </div>
                
                   
                    <div class="flex items-center space-x-4">
                        <a href=" {{ route('admin.dashboard.exportcsv', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-green-700 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Export CSV
                        </a>
                        <a href="{{ route('admin.dashboard.exportpdf', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Export PDF
                        </a>
                    </div>
                </div>
                
                
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-sortable">
                    <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                        <tr>
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Staff Name</th>
                            <th class="px-6 py-3 text-left">Type</th>
                            <th class="px-6 py-3 text-left">Start Date</th>
                            <th class="px-6 py-3 text-left">End Date</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Comment</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @forelse($leaves as $index => $leave)
                            <tr>
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $leave->user->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                                        {{ ucfirst($leave->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $leave->start_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">{{ $leave->end_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">
                                    @if($leave->status === 'approved')
                                        <span class="text-green-600 font-medium">Approved</span>
                                    @elseif($leave->status === 'rejected')
                                        <span class="text-red-600 font-medium">Rejected</span>
                                    @else
                                        <span class="text-yellow-600 font-medium">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $leave->comment ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No leave requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{$leaves->links()}}
            <script>
                function sortTableByColumn(table, column, asc=true){
                    const dirModifier=asc ? 1 : -1;
                    const tBody=table.tBodies[0];
                    const rows=Array.from(tBody.querySelectorAll("tr")); //selecting every row element
                    //sort each row
                    const sortedRows=rows.sort((a,b)=>{
                        const aColText = a.querySelector(`td:nth-child(${column+1})`).textContent.trim();
                        const bColText = b.querySelector(`td:nth-child(${column+1})`).textContent.trim();
                        const aDate = new Date(aColText);
                        const bDate = new Date(bColText);
                        return (aDate - bDate) * dirModifier;
                    });
                    //remove all existing trs from the table
                    while(tBody.firstChild){
                        tBody.removeChild(tBody.firstChild);
                    }
                    //re add the newly sorted rows
                    tBody.append(...sortedRows);
                    //remember how the column is currently sorted
                    table.querySelectorAll("th").forEach(th=>th.classList.remove("th-sort-asc","th-sort-desc"));
                    table.querySelector(`th:nth-child(${column+1})`).classList.toggle("th-sort-asc",asc);
                    table.querySelector(`th:nth-child(${column+1})`).classList.toggle("th-sort-desc",!asc);

                }
                document.querySelectorAll(".table-sortable th").forEach((headerCell,index) => {
                    if (index === 3 || index === 4) {
                    headerCell.addEventListener("click",()=>{
                        const tableElement=headerCell.parentElement.parentElement.parentElement;
                        const headerIndex=Array.prototype.indexOf.call(headerCell.parentElement.children,headerCell);
                        const currentIsAscending=headerCell.classList.contains("th-sort-asc");
                        sortTableByColumn(tableElement,headerIndex,!currentIsAscending) 
                    });
                }
                });

            </script>
        </div>

    </div>
</div>

<script>
    setTimeout(() => {
        const message = document.getElementById('successMessage');
        if (message) {
            message.style.transition = "opacity 0.5s ease";
            message.style.opacity = "0";
            setTimeout(() => message.remove(), 500);
        }
    }, 3000);
</script>

@endsection
