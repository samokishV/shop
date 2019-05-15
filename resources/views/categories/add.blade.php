@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm">
            <form action="" class="checkout" method="post" id="category-add" enctype="multipart/form-data">
                {{ csrf_field() }}
                <p><h3>Add new category</h3></p>
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" name="category" value="{{old('category')}}" class="form-control" required id="category">
                    @if ($errors->has('category'))
                        <div class="alert alert-danger">
                            {{ $errors->first('category') }}
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
                    <label for="avatar">Choose a category image:</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg">
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
@endsection
