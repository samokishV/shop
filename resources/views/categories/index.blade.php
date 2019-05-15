@extends('layouts.app')

@section('content')
    <p><h3>Categories <a href="/admin/category/add/"><button class="btn btn-sm btn-success">New category</button></a> </h3></p>
    <table class="table table-striped" style="width: 600px">
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Slug</th>
            <th></th>
        </tr>
        @foreach($categories as $category)
        <tr>
            <td>{{$category->id}}</td>
            <td>{{$category->category}}</td>
            <td><a href="/category/{{$category->slug}}">{{$category->slug}}</a></td>
            <td align="right">
                <a href="/admin/category/edit/{{$category->id}}"><button class="btn btn-sm btn-primary">edit</button></a>
                <a href="/admin/category/delete/{{$category->id}}" class="category-delete"><button class="btn btn-sm btn-warning">delete</button></a>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
