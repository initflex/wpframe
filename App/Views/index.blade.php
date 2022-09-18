@extends('layout.master')

@section('content')

<h1>Welcome - {{ $name }}</h1>
<table width="500px" border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $item)
        <tr>
            <td>{{ $item->ID }}</td>
            <td>{{ $item->user_login }}</td>
            <td>{{ $item->user_email }}</td>
        </tr>
        @endforeach 
    </tbody>
</table>

@endsection