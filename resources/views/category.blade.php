@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-4">
            <div class="card-body">
                <form method="post" action="" id="search" name="myForm">
                    {{ csrf_field() }}
                    <div class="search-options-block">
                        <h3 class="card-title">Search options</h3>
                        <div class="form-group">
                            <label for="formControlRange">
                                <h5 class="card-title">Price < <span id="slidernumber"> {{ old('price') }}</span></h5>
                            </label>
                            <input type="range" name="price" class="form-control-range" id="formControlRange" min=0 max="1000" step="50"
                                   value="{{ old('price') }}">
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success btn-lg w-100" value="Search">
                </form>
            </div>
        </div>
        <div class="col-sm-8 row d-flex justify-content-start">
            <div class="col-sm-12">
                Sorting:
                <select name="search-options">
                    <option name="default"> Default</option>
                    <option name="name-asc"> By name from A to Z </option>
                    <option name="name-desc">By name from Z to A</option>
                    <option name="price-asc">By price ascending</option>
                    <option name="price-desc">By price descending</option>
                    <option name="data-asc">From new to old</option>
                    <option name="data-desc">From old to new</option>
                </select>
            </div>
            @foreach($products as $product)
                <div class="card m-2" style="width: 18rem;">
                    <form method='post' action="" class="products">
                        <a href="/{{$product->slug}}">
                            <img class="card-img-top" src="/img/{{$product->preview}}" alt="{{$product->title}}">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title bold"><a href="/{{$product->slug}}">{{$product->title}}</a></h5>
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
            <div class="col-sm-12 d-flex justify-content-center">
               {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection


