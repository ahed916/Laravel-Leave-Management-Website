@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Staff Management') }}
    </h2>
@endsection

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <p>{{ __("Create a new user.") }}</p>
                <form action="{{ route('staff.store') }}" method="POST" class="mt-4">
                    @csrf
                
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                
                    <div class="mt-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                
                    <div class="mt-4">
                        <label for="is_admin" class="block text-sm font-medium text-gray-700">Role:</label>
                        <select name="is_admin" id="is_admin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="0">Employee</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                
                    <div class="mt-6">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Create User
                        </button>
                    </div>
                </form>
                

            </div>
        </div>

    </div>
</div>
@endsection
