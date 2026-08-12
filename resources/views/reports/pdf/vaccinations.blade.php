<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>Vaccination Report</title>

<style>

body{
font-family:DejaVu Sans,sans-serif;
font-size:12px;
}

.center{
text-align:center;
}

.summary{
margin:20px 0;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

table,th,td{
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

<div class="center">

<h3>Republic of the Philippines</h3>
<h3>Province of Sorsogon</h3>
<h3>Municipality of Irosin</h3>
<h2>Rural Health Unit</h2>

<br>

<h1>CARECRADLE</h1>

<h2>Vaccination Report</h2>

<p>
Generated:
{{ $generatedDate->format('F d, Y h:i A') }}
</p>

</div>

<div class="summary">

<p><strong>Total Vaccinations:</strong> {{ $totalVaccinations }}</p>

<p><strong>Vaccinated Infants:</strong> {{ $totalInfants }}</p>

<p><strong>Vaccine Types:</strong> {{ $vaccineTypes }}</p>

</div>

<table>

<thead>

<tr>

<th>#</th>
<th>Infant</th>
<th>Mother</th>
<th>Vaccine</th>
<th>Dose</th>
<th>Date Given</th>
<th>Next Due</th>
<th>Administered By</th>

</tr>

</thead>

<tbody>

@foreach($vaccinations as $vaccination)

<tr>

<td>{{ $loop->iteration }}</td>

<td>
{{ $vaccination->infant->first_name }}
{{ $vaccination->infant->last_name }}
</td>

<td>
{{ $vaccination->infant->mother->first_name }}
{{ $vaccination->infant->mother->last_name }}
</td>

<td>{{ $vaccination->vaccine_name }}</td>

<td>{{ $vaccination->dose }}</td>

<td>{{ \Carbon\Carbon::parse($vaccination->date_given)->format('M d, Y') }}</td>

<td>

@if($vaccination->next_due_date)

{{ \Carbon\Carbon::parse($vaccination->next_due_date)->format('M d, Y') }}

@else

-

@endif

</td>

<td>{{ $vaccination->administered_by }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>