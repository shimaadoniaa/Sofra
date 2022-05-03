@extends('layouts.app')
@inject('city','App\Model\City')
@section('head','index')
@section('page_title','Distriction')
@section('content')

    <div class="card-body">
        @can('AddDistriction')
        <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#add">
            Add Distriction
        </button>
        @endcan
        <br><br>
        @include('partials.validation_errors')

        <div class="modal" tabindex="-1" role="dialog" id="add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Distriction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">


                        {!! Form::model($districtions,[
                          'route'=>'distriction.store',
                          'method'=>'post',
                            ]) !!}
                        <div class="form-group">
                            <label for="name">Name Distriction</label>
                            <br>
                            {!! Form::text('name',null,
                               ['class'=>'form-control',
                               'placeholder'=>'Enter Distriction']) !!}
                        </div>
                        {!! Form::select('city_id',$city->pluck('name','id')->toArray(),
                               ['class'=>'form-control',
                               'placeholder'=>'Enter city']) !!}
                    </div>

                    <div class="form-group col-sm-12">

                        <br>
                        {!! Form::submit('save',
                           ['class'=>'btn btn-primary',
                           ]) !!}
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
        @if(count($districtions))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">city</th>
                    <th >process</th>

                </tr>
                </thead>
                <tbody>
                <?php $i=0; ?>
                @foreach($districtions as $distriction)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$distriction->name}}</td>
                        <td>{{$distriction->city->name}}</td>
                        <td>
                            @can('DeleteDistriction')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$distriction->id}}" title="Delete" >
                                <i class="fa fa-trash"></i></button>
                            @endcan

                            @can('EditDistriction')
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{$distriction->id}}" title="Edit" >
                                <i class="fa fa-edit"></i></button>
                            @endcan
                        </td>
                    </tr>

                    {{--      Edit Modal--}}

                    <div class="modal" tabindex="-1" role="dialog" id="edit{{$distriction->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Distriction</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    {!! Form::model($distriction,[
                                    'route'=>['distriction.update',$distriction->id],
                                     'method'=>'patch',
                                         ]) !!}

                                    <div class="form-group">
                                        <label for="name">Edit Distriction</label>
                                        <br>
                                        {!! Form::text('name',null,
                                        ['class'=>'form-control',
                                        'placeholder'=>'Enter Distriction']) !!}

                                    </div>

                                    <div class="form-group">
                                        <label for="id">Edit city</label>
                                        <br>
                                        {!! Form::select('city_id',$city->pluck('name','id')->toArray(),
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
                    <div class="modal" tabindex="-1" role="dialog" id="delete{{$distriction->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {!! Form::model($distriction,[
                                    'route'=>['distriction.destroy',$distriction->id],
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




