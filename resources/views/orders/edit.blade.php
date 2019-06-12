@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <table class="table table-striped">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                @isset($info)
                <form action="{{ route('order.edit', [$info->id]) }}" method="post">
                    {{ csrf_field() }}
                    <tr>
                        <th scope="row">{{$info->id}}</th>
                        <td>{{$info->name}}</td>
                        <td>{{$info->email}}</td>
                        <td>{{$info->phone}}</td>
                        <td>{{$info->address}}</td>
                        <td><input type="checkbox" name="processed" @if($info->processed) checked @endif></td>
                        <td><input type="submit" value="Update" class="btn btn-sm btn-warning"></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                </form>
                @endisset
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <table class="table table-striped">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Qt</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @isset($products)
                    @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>{{$product->created_at}}</td>
                        <td>{{$product->title}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->qt}}</td>
                        <td>{{$product->total}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th>Total</th>
                        <th colspan="5" class="text-right">{{$info->total}}</th>
                    </tr>
                @endisset
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
@endsection