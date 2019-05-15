@extends('layouts.app')

@section('content')
    
<h1> Pages </h1>
<div class="list-group">
    <a href="order/" class="customLink">
        <button type="button" class="list-group-item list-group-item-action">Orders</button>
    </a>
    <a href="user/" class="customLink">
        <button type="button" class="list-group-item list-group-item-action">Users</button>
    </a>
    <a href="category/" class="customLink">
        <button type="button" class="list-group-item list-group-item-action">Categories</button>
    </a>
    <a href="product/" class="customLink">
        <button type="button" class="list-group-item list-group-item-action">Products</button>
    </a>
</div>
@endsection

