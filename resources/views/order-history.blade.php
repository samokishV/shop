@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <table class="table">
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
                @isset($orders)
                    @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{$order->id}}</th>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->title}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->qt}}</td>
                        <td>{{$order->total}}</td>
                    </tr>
                    @endforeach
                    @else
                        <p>You haven't made a single order.</p>
                @endisset
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
@endsection