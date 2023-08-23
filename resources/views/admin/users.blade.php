@extends('layout') 

@section('content')
    <div class="titlebar">
        <h1>Users</h1>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Level</th>
                <th>Edit Level</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->level }}</td>
                    <td>
                        <form method="post" action="{{ route('updateUserLevel', ['id' => $user->id]) }}">
                            @csrf
                            @method('patch')
                            <select name="level">
                                <option value="1" {{ $user->level == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $user->level == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $user->level == 3 ? 'selected' : '' }}>3</option>
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <!-- Add more columns as needed -->
                    
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection