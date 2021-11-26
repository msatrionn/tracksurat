<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <img src="{{ url('./img/budur.jpg') }}" alt="" class="gambar">
    <div class="login">
        <div class="card">
            <div class="card-header head">Login</div>
            <div class=" card-body">
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block" style="display:flex;justify-content:center">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size:12px"></button>
                    <strong style="font-size:12px">{{ $message }}</strong>
                </div>
                @endif @if ($message = Session::get('warning'))
                <div class="alert alert-warning alert-block">
                    <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                    <strong style="font-size:12px">{{ $message }}</strong>
                </div>
                @endif
                <form action="{{ route('postlogin') }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="logo">
                            <img src="./img/kokid.png" width="100" alt="kokid"> SMA Negeri 1 Kota Mungkid
                        </div>
                        <br>
                    </div>
                    <br>
                    <div class="form-group user">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" id=" email" placeholder="Email" name="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group password">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            value="{{ old('password') }}" id=" password" placeholder="Password" name="password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success button">Login</button>
            </div>

            </form>
        </div>
    </div>

    </div>
</body>

</html>
