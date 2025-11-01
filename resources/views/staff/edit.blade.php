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

                <form action="{{ route('leaves.update',$leave->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')

                    <div class="mt-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="annual" {{ old('type', $leave->type) == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                            <option value="sick" {{ old('type', $leave->type) == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                            <option value="maternity" {{ old('type', $leave->type) == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                            <option value="unpaid" {{ old('type', $leave->type) == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                            <option value="other" {{ old('type', $leave->type) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $leave->start_date) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mt-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date:</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $leave->end_date) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mt-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment:</label>
                        <textarea name="comment" id="comment" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('comment', $leave->comment) }}</textarea>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Update Request
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
