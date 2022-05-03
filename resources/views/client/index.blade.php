@extends('layouts.app')
@section('head','index')
@section('page_title','Clients')
@section('content')

    <div class="card-body">


        {!! Form::open(['method'=>'GET','route'=>'client.index','class'=>'navbar-form navbar-left','role'=>'search'])  !!}


        <div class="form-group">
            <br>
            {!! Form::text('search_by_name',request('search_by_name'),
               ['class'=>'form-control',
               'placeholder'=>'search_by_name ']) !!}
        </div>

        <div class="col-sm-3">
            <br>
            {!! Form::select('distriction_id',App\Model\Distriction::pluck('name','id')->toArray(),request('distriction_id'),
               ['class'=>'navbar-form navbar-left','role'=>'search',request('distriction_id')
               ]) !!}
        </div>

        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i> search</button>
        </div>


        {!! Form::close() !!}

        <br><br>
        @include('partials.validation_errors')
        @if(count($clients))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">email</th>
                    <th scope="col">phone</th>
                    <th scope="col">distriction</th>
                    <th >process</th>

                </tr>
                </thead>
                <tbody>
                <?php $i=0; ?>
                @foreach($clients as $client)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->email}}</td>
                        <td>{{$client->phone}}</td>
                        <td>{{$client->distriction->name}}</td>
                        <td>
                            @can('DeleteClient')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$client->id}}" title="Delete" >
                                <i class="fa fa-trash"></i></button>
                            @endcan
                        </td>
                    </tr>

                    {{--          Delete Modal                    --}}
                    <div class="modal" tabindex="-1" role="dialog" id="delete{{$client->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {!! Form::model($client,[
                                    'route'=>['client.destroy',$client->id],
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




