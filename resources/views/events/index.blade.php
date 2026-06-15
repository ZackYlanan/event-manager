<!Doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
</head>
<body>
    <h1>Events</h1>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Venue</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>Slots</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->category->name?? 'Uncategorized' }}</td>
                    <td>{{ $event->venue }}</td>
                    <td>{{ $event->event_date }}</td>
                    <td>{{ $event->start_time }}</td>
                    <td>{{ $event->end_time }}</td>
                    <td>{{ $event->max_slots }}</td>
                    <td>{{ $event->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

