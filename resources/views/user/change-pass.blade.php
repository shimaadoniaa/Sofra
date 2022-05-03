@extends('layouts.app')
@inject('user',App\Model\User)
@section('head','change-password')
@section('page_title','Change Password')
@section('content')

    <div class="card-body">
        @include('partials.validation_errors')
        {!! Form::model($user,[
        'route' => ['edit-password',$user->id],
        'method' => 'post'
        ])!!}
        <div class="form-group">
            <label for="old_password">Old Password</label>
            {!! Form::password('old_password', [
            'class' =>'form-control'
            ])!!}
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            {!! Form::password('new_password', [
            'class' =>'form-control'
            ])!!}
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmation New Password</label>
            {!! Form::password('new_password_confirmation' , [
            'class' =>'form-control'
            ])!!}
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Edit</button>
        </div>
        {!! Form::close() !!}
    </div>

@endsection



