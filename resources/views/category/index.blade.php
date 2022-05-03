@extends('layouts.app')
@inject('category','App\Model\Category')
@section('head','index')
@section('page_title','Category')
@section('content')

    <div class="card-body">
@can('AddCategory')
   <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#add">
            Add Category
        </button>
        @endcan
        <br><br>
       @include('partials.validation_errors')

        <div class="modal" tabindex="-1" role="dialog" id="add">
         <div class="modal-dialog" role="document">
         <div class="modal-content">
          <div class="modal-header">
        <h5 class="modal-title">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
        </button>
         </div>
   <div class="card-body">


       {!! Form::model($category,[
         'route'=>'category.store',
         'method'=>'post',
           ]) !!}
   <div class="form-group">
       <label for="name">Name Category</label>
       <br>
       {!! Form::text('name',null,
          ['class'=>'form-control',
          'placeholder'=>'Enter Category']) !!}
      </div>
         <div class="modal-footer">
             <button type="submit" class="btn btn-primary">Save</button>
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
       {!! Form::close() !!}
      </div>
       </div>
         </div>
          </div>
        @if(count($categories))
       <table class="table table-striped">
          <thead>
          <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th >process</th>

          </tr>
          </thead>
          <tbody>
          <?php $i=0; ?>
         @foreach($categories as $category)
             <?php $i++ ?>
          <tr>
              <td>{{$i}}</td>
              <td>{{$category->name}}</td>
              <td>
                  @can('DeleteCategory')
              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$category->id}}" title="Delete" >
                  <i class="fa fa-trash"></i></button>
                  @endcan
                  @can('EditCategory')
              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{$category->id}}" title="Edit" >
                  <i class="fa fa-edit"></i></button>
                  @endcan
              </td>
          </tr>

  {{--      Edit Modal--}}

        <div class="modal" tabindex="-1" role="dialog" id="edit{{$category->id}}">
        <div class="modal-dialog" role="document">
         <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title">Edit Category</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
           </button>
           </div>
           <div class="modal-body">

               {!! Form::model($category,[
               'route'=>['category.update',$category->id],
                'method'=>'patch',
                    ]) !!}

           <div class="form-group">
               <label for="name">Edit Category</label>
               <br>
               {!! Form::text('name',null,
               ['class'=>'form-control',
               'placeholder'=>'Enter Category']) !!}

           </div>
             <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">Save</button>
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
               {!! Form::close() !!}
         </div>
              </div>
                </div>
        </div>

{{--          Delete Modal                    --}}
     <div class="modal" tabindex="-1" role="dialog" id="delete{{$category->id}}">
      <div class="modal-dialog" role="document">
       <div class="modal-content">
        <div class="modal-header">
         <h5 class="modal-title">Delete</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
         </button>
         </div>
        <div class="card-body">

    {!! Form::model($category,[
    'route'=>['category.destroy',$category->id],
    'method'=>'delete',
       ]) !!}

   <div class="form-group">
       <h4><p>Are You Sure?</p></h4>
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
        @else
            <div class="alert alert.danger" role="alert">
                No Data
            </div>
        @endif
</div>

@endsection



