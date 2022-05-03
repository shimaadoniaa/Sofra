@extends('layouts.app')
@section('head','show')
@section('page_title','Show Role')
@section('content')
    <div class="card">
        <div class="card-body">

        <div >
          <a  href="{{ route('roles.index') }}"> Back</a>
        </div>
      <br>
        <div >
        <strong>Name:</strong>
          {{ $role->name }}
        </div>

        <div >

        <strong>Permissions:</strong>

         @if(!empty($rolePermissions))
           @foreach($rolePermissions as $rolePermission)
              <li>
            <label >{{ $rolePermission->name  }}</label>
              </li>
           @endforeach
          @endif

        </div>


</div>
    </div>
@endsection
