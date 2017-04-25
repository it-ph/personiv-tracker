@extends('main')

@section('content')
	<md-card>
		<md-card-content>
			<form method="POST" action="{{ route('password.email') }}" class="form">
				<div layout="column" flex>
					{!! csrf_field() !!}

					@if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
					
					<!-- Email -->
					<md-input-container>
						<label>Email</label>
						<input id="email" type="email" name="email" value="{{ old('email') }}">
					</md-input-container>

					<div class="md-actions" layout="row">
						<!-- Submit Button -->
						<md-button type="submit" class="md-primary md-raised">Send Password Reset Link</md-button>
					</div>
				</div>
			</form>
		</md-card-content>
	</md-card>
@stop