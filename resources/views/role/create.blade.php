@extends('layouts.app')
@section('head','create')
@section('page_title','Create Role')
@section('content')

    <div class="card-body">
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div>
        @include('partials.validation_errors')
        {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
            </div>

            @foreach($permissions as $permission)

           <label> {!! Form::checkbox('permission[]',$permission->id,
                ['class'=>'name'
                    ])  !!}  {{ $permission->name }} </label>
            @endforeach
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}



    </div>
@endsection

