@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end">
        <form id="cart-delete" action="/cart/delete/" type="POST">
            {{ csrf_field() }}
            <button class="btn btn-danger btn-md align-right m-2">Delete all</button>
        </form>
    </div>
    @foreach($products as $product)
        <form method='post' action="/cart/delete/{{$product->id}}" class="products-delete">
            {{ csrf_field() }}
            <div class="row justify-content-md-center card-body cart-product">
                <div class="col col-lg-2">
                    <img src="/img/{{$product->original}}" alt="{{$product->title}}" width="80%">
                </div>
                <div class="col col-lg">
                    <h5 class="card-title bold">{{$product->title}}</h5>
                    <h5 class="card-title">&nbsp;</h5>
                    <h6 class="card-subtitle mb-2 text-muted">number of products: <span id="{{$product->id}}qt">{{$product->qt}}</span></h6>
                    <h6 class="card-subtitle mb-2 text-muted">price: <span id="{{$product->id}}price">{{$product->price}}</span> </h6>
                </div>
                <div class="col col-lg-2">
                    <div class="row">
                        <p class="cart-edit">
                            <button type="submit" class="delete-btn"><i class="far fa-times-circle"></i></button>
                        </p>
                    </div>
                    <table style="height: 100px;">
                        <tbody>
                        <tr>
                            <td class="align-middle text-right">
                                <input name="id" type="hidden" value="{{$product->id}}">
                                <input name="action" type="hidden" value="" id="{{$product->id}}action">
                                <input class="form-control w-80" type="number" id="{{$product->id}}" value="{{$product->qt}}" min="1" max="{{$product->in_stock}}" name="qt" onkeydown="return false">
                            </td>
                        </tr>
                        <tr>
                            <td class="align-middle text-right" >
                                <h4 id="{{$product->id}}total">{{$product->total}}</h4>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    @endforeach
    <div class="d-flex justify-content-end">
        <!-- TolalQt:  -->
    </div>
    <div class="row">
        <div class="w-50">
            <a href="/home/" class="cart-big-txt"><i class="fas fa-arrow-left"></i>&nbsp;Back to shopping</a>
        </div>
        <div class="w-50">
            <p class="text-right cart-big-txt">
                <a href="/order/" id="orderLink">Checkout&nbsp;<i class="fas fa-arrow-right"></i></a>
            <p>
        </div>
    </div>
@endsection