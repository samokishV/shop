@extends('layouts.app')

@section('content')
<h1> Categories </h1>
<div class="col-sm-12 row d-flex justify-content-start">
    @isset($data['categories'])
        @foreach ($data['categories'] as $category)
            <div class="card m-2" style="width: 18rem;">
                <a href="/category/{{$category->slug}}">
                    <img class="card-img-top" src="/{{$category->preview}}" alt="{{$category->category}}">
                </a>
                <div class="card-body">
                    <a href="/category/{{$category->slug}}">
                        <p class="card-text">{{$category->category}}</p>
                    </a>
                    <div class="dropdown row col-sm-12">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{$category->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Show more
                        </button>
                        <div class="dropdown-menu custom-style" aria-labelledby="dropdownMenuButton{{$category->id}}">
                            <?php echo $data['sub-menu'][$category->id]; ?>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endisset
</div>

<h1> Promo products </h1>
    <div class="col-sm-12 row d-flex justify-content-start">
        @isset($data['promo'])
            @foreach ($data['promo'] as $promo)
            <div class="card m-2" style="width: 18rem;">
                <form method='post' action="/cart/add" class="products">
                    {{ csrf_field() }}
                    <a href="/product/{{$promo->slug}}">
                        <img class="card-img-top" src="/{{$promo->preview}}" alt="{{$promo->title}}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title bold"><a href="/product/{{$promo->slug}}">{{$promo->title}}</a></h5>
                        <h5 class="card-title">{{$promo->price}}</h5>
                        @if($promo->in_stock > 0)
                        <h6 class="card-subtitle mb-2 text-muted">in stock: {{$promo->in_stock}}</h6>
                        <div class="row">
                            <div class="col-sm">
                                <div class="col-20">
                                    <input class="form-control" name="qt" type="number" value="1" min="1"  max="{{$promo->in_stock}}" id="example-number-input" onkeydown="return false">
                                    <input name="id" type="hidden" value="{{$promo->id}}">
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
        @endisset
    </div>

@endsection

