<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Report</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
        }

        h1,h2,h3,p{
            margin:0;
        }

        .center{
            text-align:center;
        }

        .mb{
            margin-bottom:15px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid black;
        }

        th{
            background:#2F64E6;
            color:white;
            padding:8px;
        }

        td{
            padding:8px;
        }

    </style>

</head>

<body>

<div class="center mb">

    <h3>Republic of the Philippines</h3>
    <h3>Province of Sorsogon</h3>
    <h3>Municipality of Irosin</h3>
    <h2>Rural Health Unit</h2>

    <br>

    <h1>CARECRADLE</h1>

    <h2>Appointment Report</h2>

    <p>
        Generated:
        {{ $generatedDate->format('F d, Y h:i A') }}
    </p>

    

</div>

<table>

<thead>

<tr>

    <th>#</th>
    <th>Mother</th>
    <th>Appointment Type</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>

</tr>

</thead>

<tbody>

@foreach($appointments as $appointment)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>
        {{ $appointment->mother->first_name }}
        {{ $appointment->mother->last_name }}
    </td>

    <td>{{ $appointment->appointment_type }}</td>

    <td>
        {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
    </td>

    <td>
        {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
    </td>

    <td>{{ $appointment->status }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>