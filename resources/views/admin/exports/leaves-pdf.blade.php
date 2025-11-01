<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leave Requests Export</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2>Leave Requests Report</h2>
    <p>Date: {{ $date }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Staff Name</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaveRequests as $index => $leave)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $leave->user->name }}</td>
                    <td>{{ ucfirst($leave->type) }}</td>
                    <td>{{ $leave->start_date->format('Y-m-d') }}</td>
                    <td>{{ $leave->end_date->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($leave->status) }}</td>
                    <td>{{ $leave->comment ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
