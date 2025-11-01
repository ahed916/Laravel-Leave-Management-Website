<p>{{ $leave->user->name }} submitted a leave request.</p>
<p>Dates: {{ $leave->start_date }} to {{ $leave->end_date }}</p>
<p>
    <a href="{{ route('admin.leaves.index') }}">
        Click here to approve or reject the leave request
    </a>
</p>