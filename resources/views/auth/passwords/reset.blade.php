@extends('main')

@section('content')
	<md-card>
		<md-card-content>
			<form method="POST" action="{{ route('password.request') }}" class="form">
				<div layout="column" flex>
					{!! csrf_field() !!}

					<input type="hidden" name="token" value="{{ $token }}">

					@if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
					
					<!-- Email -->
					<md-input-container>
						<label>Email</label>
						<input id="email" type="email" name="email" value="{{ old('email') }}">
						@if ($errors->has('email'))
							<div class="pattern">
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
							</div>
                        @endif
					</md-input-container>

					<!-- Password -->
					<md-input-container>
						<label>Password</label>
						<input id="password" type="password" name="password">
						@if ($errors->has('password'))
							<div class="pattern">
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
							</div>
                        @endif
					</md-input-container>

					<!-- Confirm Password -->
					<md-input-container>
						<label>Confirm Password</label>
						<input type="password" name="password_confirmation">
						@if ($errors->has('password_confirmation'))
							<div class="pattern">
	                            <span class="help-block">
	                                <strong>{{ $errors->first('password_confirmation') }}</strong>
	                            </span>
							</div>
                        @endif
					</md-input-container>

					<div class="md-actions" layout="row">
						<!-- Submit Button -->
						<md-button type="submit" class="md-primary md-raised">Reset Password</md-button>
					</div>
				</div>
			</form>
		</md-card-content>
	</md-card>
@stop