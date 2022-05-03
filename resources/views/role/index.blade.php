@extends('layouts.app')
@section('head','index')
@section('page_title','Role')
@section('content')

 <div class="card">
 <div class="card-body">

     @can('AddRole')
  <a href="{{url(route('roles.create'))}}" class="btn btn-primary"><i class="fa fa-plus"></i>Add Role</a>
     @endcan
     <br>
     <br>
   @include('partials.validation_errors')
   @if(count($roles))
     <div class="table-responsive">
         <table class="table table-bordered">
             <thead>
             <tr>
                 <th>#</th>
                 <th>Name</th>
                 <th class="text-center">action</th>
             </tr>
             </thead>
             <tbody>
   @foreach($roles as $role)
         <tr>
          <td>{{$loop->iteration}}</td>
          <td>{{$role->name}}</td>
          <td class="text-center">
              @can('ShowRole')
            <a  href="{{url(route('roles.show',$role->id))}}" class="btn btn-info btn-sm "><i class="fa fa-tv"></i></a>
              @endcan
{{--              @can('EditRole')--}}
              <a href="{{url(route('roles.edit',$role->id))}}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
{{--              @endcan--}}
              @can('DeleteRole')
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$role->id}}" title="Delete" >
                  <i class="fa fa-trash"></i></button>
              @endcan
          </td>

          {{--          Delete Modal                    --}}
    <div class="modal" tabindex="-1" role="dialog" id="delete{{$role->id}}">
                 <div class="modal-dialog" role="document">
                     <div class="modal-content">
                         <div class="modal-header">
                             <h5 class="modal-title">Delete</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         <div class="card-body">

                             {!! Form::model($role,[
                             'route'=>['roles.destroy',$role->id],
                             'method'=>'delete',
                                ]) !!}

                             <div class="form-group">
                                 <h4>Are You Sure?</h4>
                             </div>

                             <div class="modal-footer">
                                 <button type="submit" class="btn btn-primary">Save</button>
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                             </div>
                             {!! Form::close()!!}
                         </div>
                     </div>
                 </div>
             </div>
   @endforeach
             </tbody>
          </table>
   </div>
     @else
         <div class="alert alert.danger" role="alert">
             No Data
         </div>
     @endif
 </div>
 </div>


@endsection
