@extends('layouts.app')
@inject('city','App\Model\City')
@section('head','index')
@section('page_title','City')
@section('content')

    <div class="card-body">
        @can('DeleteCity')
        <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#add">
            Add City
        </button>
        @endcan
        <br><br>
        @include('partials.validation_errors')

        <div class="modal" tabindex="-1" role="dialog" id="add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add City</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">


                        {!! Form::model($city,[
                          'route'=>'city.store',
                          'method'=>'post',
                            ]) !!}
                        <div class="form-group">
                            <label for="name">Name City</label>
                            <br>
                            {!! Form::text('name',null,
                               ['class'=>'form-control',
                               'placeholder'=>'Enter City']) !!}
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
        @if(count($cities))
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
                @foreach($cities as $city)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$city->name}}</td>
                        <td>
                            @can('EditCity')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$city->id}}" title="Delete" >
                                <i class="fa fa-trash"></i></button>
                            @endcan

                            @can('DeleteCity')
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{$city->id}}" title="Edit" >
                                <i class="fa fa-edit"></i></button>
                            @endcan
                        </td>
                    </tr>

                    {{--      Edit Modal--}}

                    <div class="modal" tabindex="-1" role="dialog" id="edit{{$city->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit City</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    {!! Form::model($city,[
                                    'route'=>['city.update',$city->id],
                                     'method'=>'patch',
                                         ]) !!}

                                    <div class="form-group">
                                        <label for="name">Edit City</label>
                                        <br>
                                        {!! Form::text('name',null,
                                        ['class'=>'form-control',
                                        'placeholder'=>'Enter City']) !!}

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
                    <div class="modal" tabindex="-1" role="dialog" id="delete{{$city->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {!! Form::model($city,[
                                    'route'=>['city.destroy',$city->id],
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
        @else
            <div class="alert alert.danger" role="alert">
                No Data
            </div>
        @endif
    </div>

@endsection




