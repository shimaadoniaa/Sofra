@extends('layouts.app')
@section('head','Edit')
@section('page_title','Edit Role')
@section('content')
    <div class="card">
        <div class="card-body">

      @include('partials.validation_errors')
        <div >
            <a  href="{{ route('roles.index') }}"> Back</a>
        </div>

        <br>
        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}

        <div class="table-responsive">

            <div class="table table-bordered" >
                <strong>Name:</strong>

                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}

            </div>


           <div >
               <strong>Permission:</strong>

                 <br/>

               @foreach($permission as $value)

                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}

                 {{ $value->name }}</label>

                  <br/>

               @endforeach

           </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>

        {!! Form::close() !!}





</div>
    </div>
@endsection

