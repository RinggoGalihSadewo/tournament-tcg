<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tournament Ranking Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Tournament Ranking Report</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Total Poin</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $rank)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $rank->user->name }}</td>
                <td>{{ $rank->total_poin }}</td>
                <td>{{ $index + 1 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
