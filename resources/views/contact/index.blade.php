@extends('layouts.app')
@section('head','index')
@section('page_title','ContactUs')
@section('content')

    <div class="card-body">

        {!! Form::open(['method'=>'GET','route'=>'contact.index','role'=>'search'])  !!}

        <div class="row">

            <div class="col-sm-12">
                {!! Form::select('type',App\Model\Contact::pluck('type')->toArray(),request('type'),[
                  'class' => 'form-control',
                  'placeholder' => 'select type'
                  ])!!}
            </div>
            <br>
            <br>
            <div class="col-sm-12">
                {!! Form::text('search_by_message',request('search_by_message'),[
                  'class'=>'form-control',
                  'placeholder'=>'search'
                   ])  !!}

            </div>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i></button>

            </div>
        </div>
        {!! Form::close()!!}


        @include('partials.validation_errors')
        @if(count($contacts))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    {{--                    <th scope="col">order</th>--}}
                    <th scope="col">name</th>
                    <th scope="col">phone</th>
                    <th scope="col">msg</th>
                    <th scope="col">type</th>
                    <th >process</th>

                </tr>
                </thead>
                <tbody>
                <?php $i=0; ?>
                @foreach($contacts as $contact)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        {{--                        <td>{{$order->name}}</td>--}}
                        <td>{{$contact->name}}</td>
                        <td>{{$contact->phone}}</td>
                        <td>{{$contact->msg}}</td>
                        <td>{{$contact->type}}</td>
                        <td>
                            @can('DeleteContacts')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$contact->id}}" title="Delete" >
                                <i class="fa fa-trash"></i></button>
                            @endcan
                        </td>
                    </tr>

                    {{--          Delete Modal                    --}}
                    <div class="modal" tabindex="-1" role="dialog" id="delete{{$contact->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {!! Form::model($contact,[
                                    'route'=>['contact.destroy',$contact->id],
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






