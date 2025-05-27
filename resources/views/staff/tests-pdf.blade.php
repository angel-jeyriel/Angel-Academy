<!DOCTYPE html>
<html>

<head>
    <title>Test Results PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Test Results: {{ $test->title }}</h1>
    <table>
        <thead>
            <tr>
                <th>Student</th>
                <th>Score</th>
                <th>Completed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attempts as $attempt)
            <tr>
                <td>{{ $attempt->user->name }}</td>
                <td>{{ $attempt->score }} / {{ $test->questions->count() }}</td>
                <td>{{ $attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i:s') : 'Not completed' }}
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>