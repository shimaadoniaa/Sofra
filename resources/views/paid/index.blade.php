@extends('layouts.app')
@inject('city','App\Model\City')
@section('head','index')
@section('page_title','Paid')
@section('content')

    <div class="card-body">

        {!! Form::open(['method'=>'GET','route'=>'paid.index','class'=>'navbar-form navbar-left','role'=>'search'])  !!}

        <div class="row">

            <div class="col-sm-3">
                {!! Form::select('restaurant_id',App\Model\Restaurant::pluck('restaurant_name' ,'id')->toArray(),request('restaurant_id'),[
                  'class' => 'form-control',
                  'placeholder' => 'Select Restaurant'
                  ])!!}
            </div>

            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i> Search</button>
            </div>

        </div>
        {!! Form::close()!!}
        </br>
        </br>
        @can('AddPaidRestaurant')
        <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#add">
            Add Restaurant
        </button>
        @endcan
        <br><br>
        @include('partials.validation_errors')

        <div class="modal" tabindex="-1" role="dialog" id="add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Restaurant</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">


                        {!! Form::model($paids,[
                          'route'=>'paid.store',
                          'method'=>'post'
                            ]) !!}

                        <div class="col-sm-3">
                            {!! Form::select('restaurant_id',App\Model\Restaurant::pluck('restaurant_name' ,'id')->toArray(),request('restaurant_id'),[
                              'class' => 'form-control',
                              'placeholder' => 'Select Restaurant'
                              ])!!}
                        </div>

                        <div class="form-group">
                            <label for="name">amount paid</label>
                            <br>
                            {!! Form::text('amount',null,
                               ['class'=>'form-control',
                               'placeholder'=>'Enter amount']) !!}
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
        @if(count($paids))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Restaurant</th>
                    <th scope="col">amount paid</th>
                    <th >process</th>

                </tr>
                </thead>
                <tbody>
                <?php $i=0; ?>
                @foreach($paids as $paid)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$paid->restaurant->name}}</td>
                        <td>{{$paid->amount}}</td>
                        <td>
                            @can('DeletePaidRestaurant')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$paid->id}}" title="Delete" >
                                <i class="fa fa-trash"></i></button>
                            @endcan

                            @can('EditPaidRestaurnt')
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{$paid->id}}" title="Edit" >
                                <i class="fa fa-edit"></i></button>
                            @endcan
                        </td>
                    </tr>

                    {{--      Edit Modal--}}

                    <div class="modal" tabindex="-1" role="dialog" id="edit{{$paid->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit City</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    {!! Form::model($paid,[
                                    'route'=>['paid.update',$paid->id],
                                     'method'=>'patch',
                                         ]) !!}

                                    <div class="form-group">
                                        <label for="name">Edit restaurant</label>
                                        <br>
                                        {!! Form::select('restaurant_id',App\Model\Restaurant::pluck('restaurant_name' ,'id')->toArray(),request('restaurant_id'),[
                                             'class' => 'form-control',
                                             'placeholder' => 'Select Restaurant'
                                        ])!!}

                                    </div>

                                    <div class="form-group">
                                        <label for="name">Edit amount</label>
                                        <br>
                                        {!! Form::text('amount',null,
                                        ['class'=>'form-control',
                                        'placeholder'=>'Enter Amount']) !!}

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
                    <div class="modal" tabindex="-1" role="dialog" id="delete{{$paid->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {!! Form::model($paid,[
                                    'route'=>['paid.destroy',$paid->id],
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





