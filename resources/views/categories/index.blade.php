@extends('layouts.app')

@section('content')
    <p><h3>Categories <a href="{{ route('category.add') }}"><button class="btn btn-sm btn-success">New category</button></a> </h3></p>
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
            <td>{{$catFullName[$category->id]}}</td>
            <td><a href="{{ route('category.show', [$category->slug]) }}">{{$category->slug}}</a></td>
            <td align="right">
                <a href="{{ route('category.edit', [$category->id]) }}"><button class="btn btn-sm btn-primary">edit</button></a>
                <a href="{{ route('category.delete', [$category->id]) }}" class="category-delete"><button class="btn btn-sm btn-warning">delete</button></a>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
