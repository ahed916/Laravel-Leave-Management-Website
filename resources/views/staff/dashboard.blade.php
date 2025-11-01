@extends('layouts.staff')
    @section('header')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    @endsection

    @section('content')
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-5 lg:px-8 space-y-10">
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
                    const calendar = document.getElementById('calendar');
                    const baseOptions = calendar.getAttribute('options') ? JSON.parse(calendar.getAttribute('options')) : {};
                    const options = Object.assign({}, baseOptions, {
                        events: "{{ route('calendar.events.staff') }}",
                        eventDisplay: 'block',
                        navLinks: true,
                        firstDay: 1,
                        dayMaxEvents: true
                    });
                    calendar.options = options;
                });
                </script>
                
        </div>
        
        <style>
        .calendar-container full-calendar {
            max-width: 100%;
            height: 450px; 
        }
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

        </div>
    </div>
    
@endsection
