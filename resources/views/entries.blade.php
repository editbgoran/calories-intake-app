@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{asset('css/entries.css')}}">
@endpush

@section('content')
    <div class="container">
        <button id="add-new-entry" onclick="addNewEntry()">Add new entry</button>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <table id="entries-table">
                        <tr>
                            <th>User ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Text</th>
                            <th>Number of calories</th>
                        </tr>
                        <tr class="entries-data">
                        @foreach ($entries as $entry)
                            <tr class="entry-data">
                                <th>{{$entry['user_id']}}</th>
                                <th>{{$entry['date']}}</th>
                                <th>{{$entry['time']}}</th>
                                <th>{{$entry['text']}}</th>
                                <th>{{$entry['numberOfCalories']}}</th>
                                <th>
                                    <button id="edit-entry" onclick="editEntry({{$entry['id']}})">edit</button>
                                </th>
                                <th>
                                    <button id="delete-entry" onclick="deleteEntry({{$entry['id']}})">delete</button>
                                </th>
                            </tr>

                            @endforeach
                            </tr>
                    </table>

                </div>
            </div>
        </div>
        @endsection
        <script src="{{asset('js/entries.js')}}"></script>
    @push('scripts')
    @endpush
