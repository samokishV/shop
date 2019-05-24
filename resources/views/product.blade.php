@extends('layouts.app')

@section('content')
    <div class="container main">
        <div class="row">
            <div class="col-sm-5">
                <img class="d-block h-100" src="/{{$product->original_img}}" alt="First slide">
            </div>
            <div class="col-sm">
                <div class="card" style="width: 20rem;">
                    <form method='post' action="/cart/add" class="products">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <h5 class="card-title bold">{{$product->title}}</h5>
                            <h5 class="card-title">{{$product->price}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">in stock: {{$product->in_stock}} </h6>
                            <p class="card-text">{{$product->description}}</p>
                            @isset($product->additional)
                                @foreach(json_decode($product->additional) as $key=>$value)
                                    <h6 class="card-subtitle mb-2 text-muted">{{$key}} : {{$value}} </h6>
                                @endforeach
                            @endisset

                            @if($product->in_stock > 0)
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="col-20">
                                            <input class="form-control" name="qt" type="number" value="1" min="1" max="{{$product->in_stock}}" id="example-number-input" onkeydown="return false">
                                            <input type="hidden" name="id" value="{{$product->id}}">
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        <button type="submit" class="btn btn-dark w-100">Add to Cart</button>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger" role="alert">
                                    goods ended
                                </div>
                            @endif
                        </div>
                    </form>
                    <div class="col-sm-8">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


