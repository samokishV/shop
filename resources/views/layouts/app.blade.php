<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <title>
        @isset($title)
            {{ $title }}
        @endisset
    </title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand logo" href="/home/">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="/order/history">Orders</a>
                </li>
            @endauth
        </ul>
        <ul class="navbar-nav mr-right">
            <li class="nav-item">
                <form action="/product/search" method="post" class="form-inline my-2 my-lg-0">
                    {{ csrf_field() }}
                    <input name="keyword" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" value="{{old('keyword')}}" required>
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </li>
            <li class="nav-item">
                <a href="/cart/">
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-light" id="products_number">
                            @isset($productsQt)
                                {{ $productsQt }}
                            @else
                                0
                            @endisset
                        </span>
                    </button>
                </a>
            </li>
            <li class="nav-item">
                @auth
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @else
                    <li> <a class="nav-link" href="/login/">Log in</a> </li>
                @endauth
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    @yield('content')
</div>
<script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="/js/categoryPage.js"></script>
<script src="/js/cart.js"></script>
<script src="/js/user.js"></script>
</body>
</html>