@extends('layouts.app')
@push('style')
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endpush
@section('content')

    <div class="container">
        <div class="new-user">
            <button onclick="addNewUser()">Add new user</button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <table id="users-table">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                        <tr class="users-data">
                        @foreach ($users as $user)

                            <tr class="user-data">
                                <th>{{$user['name']}}</th>
                                <th>{{$user['email']}}</th>
                                <th>{{$user['role']}}</th>
                                <th>
                                    <button id="edit-user" onclick="editUser({{$user['id']}})">edit</button>
                                </th>
                                <th>
                                    <button id="delete-user" onclick="deleteUser({{$user['id']}})">delete</button>
                                </th>
                            </tr>

                            @endforeach
                            </tr>
                    </table>

                </div>
            </div>
        </div>
        @endsection
        @push('scripts')
            <script src="{{asset('js/users.js')}}"></script>
    @endpush



