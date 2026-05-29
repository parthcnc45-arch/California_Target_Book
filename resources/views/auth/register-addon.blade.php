@extends('layouts.master')
@section('title', 'Register | California Target Book')

@section('content')
<div class="container focused-form" id="register-addon">
    <div class="">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Addon Registration</h2>
                </div>

                <div class="panel-body">
                    <form class="form row" method="POST"
                        action="{{ route('auth.register_addon') }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{$user->email_token}}" />

                        <div class="col-md-12">
                            <table class="table table-striped mt-md mb-md">
                                <tbody>
                                    <tr>
                                        <th>Email</th>
                                        <td class="text-right">{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Company</th>
                                        <td class="text-right">{{ $user->company->name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name" class="control-label">First Name</label>

                                <div class="">
                                    <input id="first_name"
                                        type="text"
                                        class="form-control"
                                        name="first_name"
                                        value="{{ old('first_name') }}"
                                        required
                                        autofocus>
                                    @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name" class="control-label">Last Name</label>

                                <div class="">
                                    <input id="last_name"
                                        type="text"
                                        class="form-control"
                                        name="last_name"
                                        value="{{ old('last_name') }}"
                                        required
                                        autofocus>
                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">Password</label>

                                <div class="">
                                    <input id="password" type="password" class="form-control" name="password" required> @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password-confirm" class="control-label">Confirm Password</label>

                                <div class="">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="pull-right col-md-4">
                                <button type="submit" class="btn btn-block btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection