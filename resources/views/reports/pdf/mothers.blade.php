<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mother Report</title>

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

        .summary{
            margin-top:20px;
            margin-bottom:20px;
        }

        .summary p{
            margin:4px 0;
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

    <h2>Mother Report</h2>

    <p>
        Generated:
        {{ $generatedDate->format('F d, Y h:i A') }}
    </p>

</div>

<div class="summary">

    <p><strong>Total Mothers:</strong> {{ $totalMothers }}</p>

    <p><strong>Pregnant:</strong> {{ $pregnant }}</p>

    <p><strong>Delivered:</strong> {{ $delivered }}</p>

    <p><strong>Referred:</strong> {{ $referred }}</p>

</div>

<table>

<thead>

<tr>

    <th>#</th>
    <th>Mother Code</th>
    <th>Full Name</th>
    <th>Barangay</th>
    <th>Contact Number</th>
    <th>Status</th>

</tr>

</thead>

<tbody>

@foreach($mothers as $mother)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $mother->mother_code }}</td>

    <td>
        {{ $mother->first_name }}
        {{ $mother->middle_name }}
        {{ $mother->last_name }}
    </td>

    <td>{{ $mother->barangay }}</td>

    <td>{{ $mother->contact_number }}</td>

    <td>{{ $mother->status }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>