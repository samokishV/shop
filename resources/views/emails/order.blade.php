<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>New order created</h2>

<table>
    <tr>
        <td>
            <table border="1" cellpadding="20" cellspacing="0" width="600">
                <thead class="thead-default">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($content as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->address}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </td>
    </tr>
    <tr>
        <td height="20px">

        </td>
    </tr>
    <tr>
        <td>
            <table border="1" cellpadding="20" cellspacing="0" width="600">
                <thead class="thead-default">
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Qt</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($content as $order)
                    <tr>
                        <th scope="row">{{$order->id}}</th>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->title}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->qt}}</td>
                        <td>{{$order->total}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </td>
    </tr>
    <tr>
        <td height="20px">

        </td>
    </tr>
    <tr>
        <td>
            <a style="font-size:20px" href="{{$link}}">Edit order</a>
        </td>
    </tr>
</table>

</body>
</html>


