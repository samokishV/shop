@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm">
            <form action="" class="checkout" method="post" id="user-add">
                {{ csrf_field() }}
                <p><h3>Add new user</h3></p>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{old('email')}}" class="form-control" required id="email">
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="{{old('password')}}" class="form-control" required id="password">
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role">
                        <option value="user" @if(old('role')=="user") selected @endif>User</option>
                        <option value="manager" @if(old('role')=="manager") selected @endif>Manager</option>
                        <option value="admin" @if(old('role')=="admin") selected @endif>Admin</option>
                        <option value="guest" @if(old('role')=="guest") selected @endif>Guest</option>
                    </select>
                    @if ($errors->has('role'))
                        <div class="alert alert-danger">
                            {{ $errors->first('role') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="timezone">Timezone</label>
                    <input type="text" name=timezone value="{{old('timezone')}}" class="form-control" id="timezone">
                    @if ($errors->has('timezone'))
                        <div class="alert alert-danger">
                            {{ $errors->first('timezone') }}
                        </div>
                    @endif
                </div>
                <input type="submit" class="btn btn-success btn-lg w-100" value="Submit">
            </form>
        </div>
    </div>
@endsection
