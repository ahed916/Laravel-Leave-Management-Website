@extends('layouts.admin') 

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('User Management') }}
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

        <div class="p-6 bg-gray-100 text-left">
            <a href="{{ route('staff.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition duration-300 ease-in-out">
                + Create New User
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-700 text-sm font-semibold">
                    <tr>
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Created At</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @foreach($users as $index => $user)
                        <tr>
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $user->is_admin ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $user->is_admin ? 'Admin' : 'Employee' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->status)
                                    <span class="text-green-600 font-medium">Active</span>
                                @else
                                    <span class="text-red-600 font-medium">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 space-x-2">
                               
                                    <a href="{{ route('staff.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a>

                                    <form action="{{ route('staff.delete', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</button>
                                    </form>

                                    <form action="{{ route('staff.toggleStatus', $user->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="text-yellow-600 hover:underline">
                                            {{ $user->status ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        {{ $users->links() }}

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
