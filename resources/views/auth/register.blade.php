@extends('main')

@section('content')
	<md-card ng-controller="registrationController as vm">
		<md-card-content>
			<form method="POST" action="{{ route('register') }}" class="form-large">
				<div layout="column" flex>
					{!! csrf_field() !!}

					<md-button ng-click="vm.test()">Test</md-button>
					<!-- Employee Number -->
					<md-input-container>
						<label>Employee Number</label>
						<input type="text" name="employee_number" value="{{ old('employee_number') }}" required>
						@if ($errors->has('email'))
							<div class="pattern">
								<span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
							</div>
						@endif
					</md-input-container>
					
					<div layout="row" flex layout-wrap>
						<!-- First Name -->
						<md-input-container class="md-block" flex-xs="100" flex-sm="100" flex-gt-sm="25">
							<label>First Name</label>
							<input type="text" name="first_name" value="{{ old('first_name') }}" required>
							@if ($errors->has('first_name'))
								<div class="pattern">
									<span class="help-block">
	                                    <strong>{{ $errors->first('first_name') }}</strong>
	                                </span>
								</div>
							@endif
						</md-input-container>
						<!-- Middle Name -->
						<md-input-container class="md-block" flex-xs="100" flex-sm="100" flex-gt-sm="25">
							<label>Middle Name</label>
							<input type="text" name="middle_name" value="{{ old('middle_name') }}">
							@if ($errors->has('middle_name'))
								<div class="pattern">
									<span class="help-block">
	                                    <strong>{{ $errors->first('middle_name') }}</strong>
	                                </span>
								</div>
							@endif
						</md-input-container>
						<!-- Last Name -->
						<md-input-container class="md-block" flex-xs="100" flex-sm="100" flex-gt-sm="25">
							<label>Last Name</label>
							<input type="text" name="last_name" value="{{ old('last_name') }}" required>
							@if ($errors->has('last_name'))
								<div class="pattern">
									<span class="help-block">
	                                    <strong>{{ $errors->first('last_name') }}</strong>
	                                </span>
								</div>
							@endif
						</md-input-container>
						<!-- Suffix -->
						<md-input-container class="md-block" flex-xs="100" flex-sm="100" flex-gt-sm="25">
							<label>Suffix</label>
							<input type="text" name="suffix" value="{{ old('suffix') }}">
							@if ($errors->has('suffix'))
								<div class="pattern">
									<span class="help-block">
	                                    <strong>{{ $errors->first('suffix') }}</strong>
	                                </span>
								</div>
							@endif
						</md-input-container>
					</div>
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