@extends('layouts.app')

@section('content')
    <p><h3>Users <a href="{{ route('user.add') }}"><button class="btn btn-sm btn-success">New user</button></a> </h3></p>
    <table class="table table-striped" style="width: 600px">
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->role}}</td>
            <td align="right">
                <a href="{{ route('user.edit', [$user->id]) }}"><button class="btn btn-sm btn-primary">edit</button></a>
                <a href="{{ route('user.delete', [$user->id]) }}" class="user-delete"><button class="btn btn-sm btn-warning">delete</button></a>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
