@extends('layout')

@section('table')
<table id="user_list" class="table table-bordered">
    <thead>
        <tr>
            <th>Year</th>
            <th>Rank</th>
            <th>Recipient</th>
            <th>Country</th>
            <th>Career</th>
            <th>Tied</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
        @if (empty($aData) === true)
        <tr>
            <td colspan="7">No data available.</td>
        </tr>
        @else
            @foreach ($aData as $aItem)
                <tr>
                    <td>{{ $aItem['year'] }}</td>
                    <td>{{ $aItem['rank'] }}</td>
                    <td>{{ $aItem['recipient'] }}</td>
                    <td>{{ $aItem['country'] }}</td>
                    <td>{{ $aItem['career'] }}</td>
                    <td>{{ $aItem['tied'] }}</td>
                    <td>{{ $aItem['title'] }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@endsection
