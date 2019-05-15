@extends('layouts.app')

@section('content')
    <p><h3>Orders <a id="orderEditBtn"><button class="btn btn-sm btn-success">Update all</button></a></h3></p>
    <table class="table table-striped" style="width: 800px">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Processed</th>
            <th> </th>
        </tr>
        @foreach($orders as $order)
            <form class="order-edit" action="/admin/order/edit/{{$order->id}}" method="post">
                {{ csrf_field() }}
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->name}}</td>
                    <td>{{$order->email}}</td>
                    <td>{{$order->phone}}</td>
                    <td><input id="{{$order->id}}" type="checkbox" name="processed" @if($order->processed) checked @endif></td>
                    <td align="right">
                        <a href="/admin/order/edit/{{$order->id}}" class="btn btn-sm btn-primary">Show details</a>
                        <input type="submit" value="Update" class="btn btn-sm btn-warning">
                    </td>
                </tr>
            </form>
        @endforeach
    </table>
@endsection