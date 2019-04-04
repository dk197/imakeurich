@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2>Change your rich Profile</h2>
            <input type="hidden" id="user_id_user" value="{{Auth::user()->id }}">
            <form  id="user_change_form" method="POST" action="/change/{{ Auth::user()->id  }}">
                {{ csrf_field() }}
                <div class="form-group"  >
                    <label for="InputUsername">Username: </label>
                    <small>   (if you dont want to change it: type your current)</small>
                    <input type="text" class="form-control" autocomplete="new-username" id="username" name="username" required aria-describedby="emailHelp" placeholder="Enter Username" value="{{Auth::user()->username}}">
                </div>
                <div class="form-group">
                  <label for="email">Email address: </label>
                  <small>   (if you dont want to change it: type your current)</small>
                  <input type="email" class="form-control" autocomplete="new-email" id="email" aria-describedby="emailHelp" required name="email" placeholder="Enter email" value="{{Auth::user()->email}}">
                  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                  <label for="InputPassword">Password: </label>
                  <small>   (if you dont want to change it: type your current)</small>
                  <input type="password" autocomplete="new-password" class="form-control" id="password" name="password" required placeholder="Password">
                </div>
                <button type="submit" id="userChangeSubmit" class="btn btn-primary button-purple">Submit</button>
              </form>
        </div>
    </div>
</div>
@endsection
