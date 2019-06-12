@extends('layouts.app')

@section('content')
    <p><h3>Products <a href="{{ route('product.add') }}"><button class="btn btn-sm btn-success">New product</button></a>
        <a id="productEditBtn"><button class="btn btn-sm btn-primary">Update all</button></a></h3></p>
    <table class="table table-striped" style="width: 800px">
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Price</th>
            <th>In stock</th>
            <th>Promo</th>
            <th>Category</th>
            <th> </th>
        </tr>
        @foreach($products as $product)
            <form class="product-edit" action="{{ route('promo.edit', [$product->id]) }}" method="post">
                {{ csrf_field() }}
                <tr>
                    <td>{{$product->id}}</td>
                    <td>
                        <a href="{{ route('product.show', [$product->slug]) }}">
                            {{$product->title}}
                        </a>
                    </td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->in_stock}}</td>
                    <td><input id="{{$product->id}}" name="promo" type="checkbox" @if($product->promo) checked @endif ></td>
                    <td>{{$catFullName[$product->catId]}}</td>
                    <td align="right">
                        <a href="{{ route('product.edit', [$product->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="/admin/product/delete/{{$product->id}}" class="product-delete"><button class="btn btn-sm btn-warning">Delete</button></a>
                        <input type="submit" value="Update" class="btn btn-sm btn-success">
                    </td>
                </tr>
            </form>
        @endforeach
    </table>
@endsection
