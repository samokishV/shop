@extends('layouts.app')

@section('content')
    
<h1> Pages </h1>
<div class="list-group">
    <a href="{{ route('admin.order.index') }}" class="customLink">
        <button type="button" class="list-group-item list-group-item-action">Orders</button>
    </a>
    <a href="{{ route('admin.user.index') }}" class="customLink">
        <button type="button" class="list-group-item list-group-item-action">Users</button>
    </a>
    <a href="{{ route('admin.category.index') }}" class="customLink">
        <button type="button" class="list-group-item list-group-item-action">Categories</button>
    </a>
    <a href="{{ route('admin.product.index') }}" class="customLink">
        <button type="button" class="list-group-item list-group-item-action">Products</button>
    </a>
</div>
@endsection

