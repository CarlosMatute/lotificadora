@extends('layouts.appLogin')

@section('content')
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>Iniciar Sesion</h3>
				<!--<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>-->
			</div>
			<div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                        @csrf
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="email" placeholder="Usuario" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
						
                        @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input id="password" type="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
					
                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    
                    </div>
					<!--<div class="row align-items-center remember">
						<input type="checkbox">Remember Me
					</div>-->
					<div class="form-group">
						
                        <button type="submit" class="btn float-left login_btn">
                                    {{ __('Iniciar') }}
                                </button>
                        <br><br><br>
                        <center>
                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-sm btn-link btn-light" href="{{ route('password.request') }}">
                                        {{ __('Olvide mi contraseña') }}
                                    </a>
                                @endif -->
                        </center>
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					GRUPO RIVERA CARVAJAL &copy; <?php echo date('Y'); ?><!--<a href="#">Sign Up</a>-->
				</div>
				<!--<div class="d-flex justify-content-center">
					<a href="#">Forgot your password?</a>
				</div>-->
			</div>
		</div>
	</div>
</div>
@endsection
