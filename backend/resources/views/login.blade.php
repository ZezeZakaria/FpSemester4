<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopNjoy || Login Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>

<body>
    <div class="container border p-5 mt-5">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <div class="login-form">
                    <h2 class="text-center">Sign In</h2>
                    <form class="form" method="post" action="{{ route('login_store') }}">
                        {{-- <form action="" method="post"></form> --}}
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="email">Your Email<span>*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder=""
                                        required="required" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">Your Password<span>*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder=""
                                        required="required" value="{{ old('password') }}">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="social-btn text-center">
                                {{-- <a href="{{ route('login.redirect', 'google') }}" class="btn btn-google"><i
                                    class="ti-google"></i> Sign In With Google</a> --}}
                            </div>
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                                <div class="checkbox">
                                    <label class="checkbox-inline" for="2"><input name="news" id="2"
                                            type="checkbox">Remember me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="lost-pass" href="{{ route('password.reset') }}">
                                        Lost your password?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <p class="text-center">Not a member? <a href="#">Sign up now</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
