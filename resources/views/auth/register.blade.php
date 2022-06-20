@extends('auth')

@section('content')
<main class="col-12 col-lg-5">
    <div class="mb-5 text-center">
        <h1>Please <span class="font-cursive">sign up</span></h1>
    </div>
    <div class="card shadow-lg w-auto">
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}" class="w-100 my-auto">
                @csrf

                <div class="form-group row">
                    <div class="col-12">
                        <label for="name" class="font-weight-bold text-uppercase text-muted small"> Name </label>
                        <input type="name" name="name" value="{{ old('name') }}" id="name" class="form-control border-0 @error('email') is-invalid @enderror" placeholder="Surname first" required autofocus />
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="email" class="font-weight-bold text-uppercase text-muted small"> Email </label>
                        <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control border-0 @error('email') is-invalid @enderror" placeholder="Email address" required autofocus />
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <label for="password" class="font-weight-bold text-uppercase text-muted small"> Password </label>
                        <input type="password" name="password" id="password" class="form-control border-0 @error('password') is-invalid @enderror" placeholder="Password" required />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <label for="password_confirmation" class="font-weight-bold text-uppercase text-muted small"> Confirm Password </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-0 @error('password') is-invalid @enderror" placeholder="Confirm Password" required />
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12">
                        <button class="btn btn-success btn-block mt-3" type="submit">Sign up</button>
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-center mt-3">
                <a class="btn btn-link text-decoration-none" href="{{ route('login') }}"> Already registered? </a>
            </div>
        </div>
    </div>
    <div class="mt-5 text-center">
        <p class="text-muted">Powered by <a href="https://bookrema.com" class="text-primary text-decoration-none">Bookrema</a></p>
    </div>
</main>
@endsection
