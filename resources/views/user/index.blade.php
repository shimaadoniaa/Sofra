@extends('layouts.app')
@section('head','index')
@section('page_title','Users')
@section('content')

   <div class="card-body">

       <div class="row">
           <div class="col-lg-12 margin-tb">
               <div class=”pull-right”>
                   @can('AddUser')
                   <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
                   @endcan
               </div>
           </div>
       </div>
       <br>

     @include('partials.validation_errors')
      @if(count($users))
       <table class="table table-bordered">
           <tr>
               <th>No</th>
               <th>Name</th>
               <th>Email</th>
               <th>Roles</th>
               <th width="280px">Action</th>
           </tr>
           @foreach ($users as $key => $user)
               <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>{{ $user->name }}</td>
                   <td>{{ $user->email }}</td>
                   <td>
                       @if(!empty($user->getRoleNames()))
                           @foreach($user->getRoleNames() as $v)
                               <label class="badge badge-success">{{ $v }}</label>
                           @endforeach
                       @endif
                   </td>
                   <td>
                       @can('ShowUser')
                       <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                       @endcan
                           @can('EditUser')
                       <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                           @endcan

                       {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                           @can('DeleteUser')
                       {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                           @endcan
                       {!! Form::close() !!}
                   </td>
               </tr>
           @endforeach
       </table>
       @else
           <div class="alert alert.danger" role="alert">
               No Data
           </div>
       @endif


   </div>


@endsection
