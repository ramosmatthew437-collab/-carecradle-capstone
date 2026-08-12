<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Infant Report</title>

<style>

body{
font-family:DejaVu Sans,sans-serif;
font-size:12px;
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

.center{
text-align:center;
}

.summary{
margin:20px 0;
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

<h2>Infant Report</h2>

<p>
Generated:
{{ $generatedDate->format('F d, Y h:i A') }}
</p>

</div>

<div class="summary">

<p><strong>Total Infants:</strong> {{ $totalInfants }}</p>

<p><strong>Male:</strong> {{ $male }}</p>

<p><strong>Female:</strong> {{ $female }}</p>

</div>

<table>

<thead>

<tr>

<th>#</th>
<th>Infant ID</th>
<th>Infant Name</th>
<th>Mother</th>
<th>Sex</th>
<th>Birth Date</th>
<th>Birth Status</th>

</tr>

</thead>

<tbody>

@foreach($infants as $infant)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $infant->id }}</td>

<td>
{{ $infant->first_name }}
{{ $infant->middle_name }}
{{ $infant->last_name }}
</td>

<td>
{{ $infant->mother->first_name }}
{{ $infant->mother->last_name }}
</td>

<td>{{ $infant->sex }}</td>

<td>{{ \Carbon\Carbon::parse($infant->birth_date)->format('M d, Y') }}</td>

<td>{{ $infant->birth_status }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>