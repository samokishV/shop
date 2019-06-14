@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm">
            <form action="" class="checkout" method="post" id="category-add" enctype="multipart/form-data">
                {{ csrf_field() }}
                <p><h3>Edit category</h3></p>
                <div class="form-group">
                    <label for="parent_category">Parent category</label>
                    <select name="parent_category" id="parent_category">
                        <option value="0"> </option>
                        @foreach($categories as $cat)
                            <option value="{{$cat->id}}" @if($cat->id==old('parent_category', $category->parent_id)) selected @endif>
                                {{$catFullName[$cat->id]}}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('parent_category'))
                        <div class="alert alert-danger">
                            {{ $errors->first('parent_category') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" name="category" value="{{old('category', $category->category)}}" class="form-control" required id="category">
                    @if ($errors->has('category'))
                        <div class="alert alert-danger">
                            {{ $errors->first('category') }}
                        </div>
                    @endif

                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" value="{{old('slug', $category->slug)}}" class="form-control" required id="slug">
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
        <img src="{{asset($category->original_img)}}" id="img-preview">
    </div>
@endsection
