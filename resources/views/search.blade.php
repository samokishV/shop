@extends('layouts.app')

@section('content')

    <h1> Search results </h1>
    @foreach($products as $key=>$group)
        <h3> {{$key}} </h3>
        <div class="col-sm-12 row d-flex justify-content-start">
            @foreach($group as $product)
            <div class="card m-2" style="width: 18rem;">
                <form method='post' action="/cart/add" class="products">
                    {{ csrf_field() }}
                    <a href="/product/{{$product->slug}}">
                        <img class="card-img-top" src="/{{$product->preview}}" alt="{{$product->title}}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title bold"><a href="/product/{{$product->slug}}">{{$product->title}}</a></h5>
                        <h5 class="card-title">{{$product->price}}</h5>
                        @if($product->in_stock > 0)
                            <h6 class="card-subtitle mb-2 text-muted">in stock: {{$product->in_stock}}</h6>
                            <div class="row">
                                <div class="col-sm">
                                    <div class="col-20">
                                        <input class="form-control" name="qt" type="number" value="1" min="1"  max="{{$product->in_stock}}" id="example-number-input">
                                        <input name="id" type="hidden" value="{{$product->id}}">
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <input type="submit" class="btn btn-dark w-100" value="Add to Cart">
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                goods ended
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    @endforeach

@endsection