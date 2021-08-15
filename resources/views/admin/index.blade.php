@extends('layouts.index')

@section('content')
<div class="container">
    
    <div class="alert-info">{{session('msg')}}</div>
    <h1>Add Keys</h1>
    <form action="/admin/add" method="post">
        @csrf
        <input type="text" name="stkey" class="form-control" placeholder="Enter Key">
        <br>
        <button class="btn btn-primary">Submit</button>
    </form>

<br>

<h1>Set Generation Limit</h1>

<table class="table">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Generation Limit</th>
        <th>Set Generation Limit</th>
    </tr>
@foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        @if(empty($user->gen_limit))
            <td><button class="btn btn-outline-dark">Not Set</button></td>
        @else
            <td>{{$user->gen_limit}}</td>
        @endif
        <td>
        <form action="/admin/set_limit" method="post">
            @csrf
            @method('patch')
            <input type="hidden" name="user_id" value = "{{$user->id}}">
            <input type="number" name="gen_limit" style="width: 50px; padding-bottom: 5px;">
            <button class="btn btn-dark">Submit</button>
        </form>
        </td>
    </tr>
@endforeach
</table>

</div>





@endsection