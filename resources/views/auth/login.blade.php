@extends('auth.layouts.app')

@section('content')
    <div class="container">
        <div class="signup-content">
            <form method="POST" id="signup-form" class="signup-form" action="{{url('post-login')}}" method="POST">
                {{ csrf_field() }}
                <h2>Login</h2>
                <p class="desc">Aplikasi <b>SEWAKU</b> dibuat oleh <a href="https://next-in.id" style="color: white"> <span>“next-in.id”</span></a></p>
                <div class="form-group">
                    <input type="text" class="form-input" name="username" id="username" placeholder="No HP / Email" required />
                    <span class="focus-input100" data-placeholder="&#xf207;"    style="color:red;padding-left: 35px;padding-top: 45px;font-style: italic;font-size: 15px">@if ($errors->has('username')){{ $errors->first('username') }}@endif </span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-input" name="password" id="password" placeholder="Password" required/>
                    <span toggle="#password" class="zmdi field-icon toggle-password zmdi-eye-off"></span>
                    <span class="focus-input100" data-placeholder="&#xf191;"    style="color:red;padding-left: 35px;padding-top: 45px;font-style: italic;font-size: 15px">@if ($errors->has('password')){{ $errors->first('password') }}@endif</span>
                </div>
                <div class="form-group">
                    <!-- <input type="checkbox" name="remember" id="remember" class="agree-term" {{ old('remember') ? 'checked' : '' }}/><label for="agree-term" class="label-agree-term"><span><span></span></span>Remember me  -->
                    <br>My Contact : <a href="next-in.id@gmail." class="term-service">next-in.id@gmail.com</a></label>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" id="submit" class="form-submit submit" value="Sign in"/>
                </div>
            </form>
        </div>
    </div>
@endsection

   