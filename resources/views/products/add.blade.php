@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm">
            <form action="" method="post" id="product-add" enctype="multipart/form-data">
                {{ csrf_field() }}
                <p><h3>Add new product</h3></p>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" value="{{old('title')}}" class="form-control" required id="title">
                    @if ($errors->has('title'))
                        <div class="alert alert-danger">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" value="{{old('slug')}}" class="form-control" required id="slug">
                    @if ($errors->has('slug'))
                        <div class="alert alert-danger">
                            {{ $errors->first('slug') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" name="price" value="{{old('price')}}" class="form-control" required id="price">
                    @if ($errors->has('price'))
                        <div class="alert alert-danger">
                            {{ $errors->first('price') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="in_stock">In stock</label>
                    <input type="text" name="in_stock" value="{{old('in_stock')}}" class="form-control" required id="in_stock">
                    @if ($errors->has('in_stock'))
                        <div class="alert alert-danger">
                            {{ $errors->first('in_stock') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" required>{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                        <div class="alert alert-danger">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if(old('category')==$category->id) selected @endif>{{$catFullName[$category->id]}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category'))
                        <div class="alert alert-danger">
                            {{ $errors->first('category') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="promo">
                        <input name="promo" type="checkbox" @if(old('promo')) checked @endif > Promo product
                    </label>
                    @if ($errors->has('promo'))
                        <div class="alert alert-danger">
                            {{ $errors->first('promo') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="additional">Additional <a class="btn btn-sm btn-success text-light ml-2" id="add-new-feature" onclick="e.preventDefault()">Add new features</a></label>
                    <input name="additional" type="hidden" id="additional" class="form-control" value="{{old('additional')}}">
                    <div id="new-features"></div>
                    <?php $additional = json_decode(old('additional'), true); ?>
                    @isset($additional)
                        @foreach($additional as $key=>$value)
                            <div class='row mt-4 mb-4 feature-group'>
                                <div class='col-sm-5'>
                                    <label>Feature name</label>
                                    <input class='feature w-100' value="{{$key}}">
                                </div>
                                <div class='col-sm-5'>
                                    <label>Value</label>
                                    <input class='feature-value w-100' value={{$value}}>
                                </div>
                                <div class="col-sm-2 my-auto">
                                    <a class="btn btn-sm btn-success text-light remove-feature">Delete feature</a>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                    @if ($errors->has('additional'))
                        <div class="alert alert-danger">
                            {{ $errors->first('additional') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="avatar">Choose a product image:</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg" value="{{old('image')}}">
                    @if ($errors->has('image'))
                        <div class="alert alert-danger">
                            {{ $errors->first('image') }}
                        </div>
                    @endif
                    <p> Accepted Image Formats: jpeg, png.</p>
                    <p> Min image size: 400 x 400 </p>
                </div>
                <input type="submit" class="btn btn-success btn-lg w-100" value="Submit">
            </form>
        </div>
    </div>
    <div class="row">
        <img src="" id="img-preview">
    </div>
    @include('products.feature')
@endsection


