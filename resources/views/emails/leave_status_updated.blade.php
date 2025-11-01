<p>Hello {{ $leave->user->name }},</p>
<p>Your leave request from {{ $leave->start_date }} to {{ $leave->end_date }} has been <strong>{{ $leave->status }}</strong>.</p>
