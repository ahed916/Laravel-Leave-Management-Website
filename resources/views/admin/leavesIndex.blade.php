@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Leave Requests Management') }}
    </h2>
@endsection

@section('content')

@if(session('success'))
    <div class="flex justify-center">
        <div id="successMessage" class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded shadow w-full max-w-md text-center">
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-5 lg:px-8">

        

        <div class="bg-white border border-gray-200 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Staff Name</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Start Date</th>
                        <th class="px-6 py-3 text-left">End Date</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Comment</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @forelse($leaves as $index => $leave)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td  class="px-6 py-4">{{ $leave->user->name }}</td>
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
                            <td class="px-6 py-4 space-x-2">
                                @if($leave->status == 'pending')
                                <form action="{{ route('admin.leaves.validate', $leave->id) }}" method="POST" class="inline">
                                 @csrf
                                <button class="text-green-600 hover:underline">Approve</button>
                                </form>
                                <form action="{{ route('admin.leaves.reject', $leave->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-red-600 hover:underline">Reject</button>
                                </form>
                                @else
                                <span>-</span>
                                @endif
                                        
                                   
                            </td>
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
