@extends('layouts.app')

@push('style')
    <link rel="stylesheet" href="{{asset('css/user_entries.css')}}">
@endpush

@section('content')
    <div class="container">
            <button id="add-new-entry" onclick="addNewEntry()">Add new entry</button>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div id="filter">
                        <label for="from-date">From:</label>
                        <input type="date" id="from-date" name="from-date">
                        <label for="to-date">To:</label>
                        <input type="date" id="to-date" name="to-date">
                        <label for="from-hour">From:</label>
                        <input type="time" id="from-hour" name="from-hour">
                        <label for="to-hour">To:</label>
                        <input type="time" id="to-hour" name="to-hour">
                        <button onclick="filterTableByDatetime()">Filter</button>
                    </div>
                    <br>
                    <table id="entries-table">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Text</th>
                            <th>Number of calories</th>
                        </tr>
                        <tr class="entries-data">
                        @foreach ($user_entries as $entry)

                            <tr class="entry-data">
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
                    <div>
                        <label for="">Enter the expected number of calories:</label>
                        <input type="text" id="excepted-number-of-calories">
                        <button id="calories-button"  onclick="checkCalories()">Check calories for today</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('scripts')
            <script src="{{asset('js/user_entries.js')}}"></script>
@endpush
