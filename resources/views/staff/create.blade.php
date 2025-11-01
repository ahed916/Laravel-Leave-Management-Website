@extends('layouts.staff')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Leave Requests') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if($errors->any())
            <div class="flex justify-center">
                <div class="bg-red-100 text-red-800 px-4 py-2 mb-4 rounded shadow w-full max-w-md text-center">
                    <ul class="list-disc list-inside text-left text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <p>{{ __("New Leave Request.") }}</p>

                
                <form action="{{ route('leaves.store') }}" method="POST" class="mt-4">
                    @csrf
                
                    <div class="mt-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="annual">Annual Leave</option>
                            <option value="sick">Sick Leave</option>
                            <option value="maternity">Maternity Leave</option>
                            <option value="unpaid">Unpaid Leave</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                
                    <div class="mt-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                
                    <div class="mt-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date:</label>
                        <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mt-4">
                        <label for="admin_id" class="block text-sm font-medium text-gray-700">Select Admin</label>
                        <p class="italic text-gray-500"> Pick the admin who will review and approve your leave request </p>
                        <select name="admin_id" id="admin_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value=""> Choose admin </option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment:</label>
                        <textarea name="comment" id="comment" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" ></textarea>
                    </div>
                   
                   
                
                    <div class="mt-6">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Submit Request
                        </button>
                    </div>
                </form>
                

            </div>
        </div>

    </div>
</div>
@endsection
