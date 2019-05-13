@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm">
            <form action="" class="checkout" method="post">
                {{ csrf_field() }}
                <p><h3>Checkout</h3></p>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{old('name')}}" class="form-control" required id="name">
                    @if ($errors->has('name'))
                        <div class="alert alert-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                </div>
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
                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" value="{{old('phone')}}" class="form-control" required id="phone">
                    @if ($errors->has('phone'))
                        <div class="alert alert-danger">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" value="{{old('address')}}" class="form-control" required id="address">
                    @if ($errors->has('address'))
                        <div class="alert alert-danger">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                </div>
                <input type="hidden">
                @isset($cart[0])
                    <input type="submit" class="btn btn-success btn-lg w-100" value="Checkout">
                @endisset

                @empty($cart[0])
                    <h3>Please add items to make an order!</h3>
                @endempty

            </form>
        </div>
        <div class="col-sm">
            <p><h3>Your order</h3></p>
            <table border cellspacing="0" width="400px" class="order-table">
                <tr><th>Product</th><th>Price</th></tr>
                <?php $total_price = 0; ?>
                @isset($cart)
                    @foreach ($cart as $product)
                        <?php $total_price += $product->total; ?>
                        <tr>
                            <td><?=$product->title; ?> x <?=$product->qt; ?></td>
                            <td><?=$product->total; ?> ₴ </td>
                        </tr>
                    @endforeach
                @endisset
                <tr>
                    <th>Total</th>
                    <th>{{$total_price}} ₴ </th>
                </tr>
            </table>
        </div>
    </div>
@endsection
