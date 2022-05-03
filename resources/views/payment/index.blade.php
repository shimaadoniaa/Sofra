@extends('layouts.app')
@inject('category','App\Model\Category')
@section('head','index')
@section('page_title','Payment Meathods')
@section('content')

<div class="card-body">
    @can('AddPaymentMethod')
    <button type="button" class="btn btn-success"  data-toggle="modal" data-target="#add">
        Add paymentmethods
    </button>
    @endcan
    <br><br>
    @include('partials.validation_errors')

    <div class="modal" tabindex="-1" role="dialog" id="add">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add payment methods</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">


                    {!! Form::model($payment_methods,[
                    'route'=>'payment.store',
                    'method'=>'post',
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Name Category</label>
                        <br>
                        {!! Form::text('name',null,
                        ['class'=>'form-control',
                        'placeholder'=>'Enter payment method']) !!}
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
    @if(count($payment_methods))
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
        @foreach($payment_methods as $payment_method)
        <?php $i++ ?>
        <tr>
            <td>{{$i}}</td>
            <td>{{$payment_method->name}}</td>
            <td>
                @can('DeletePaymentMethod')
                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$payment_method->id}}" title="Delete" >
                    <i class="fa fa-trash"></i></button>
                @endcan

                @can('EditPaymentMethod')
                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{$payment_method->id}}" title="Edit" >
                    <i class="fa fa-edit"></i></button>
                @endcan
            </td>
        </tr>

        {{--      Edit Modal--}}

        <div class="modal" tabindex="-1" role="dialog" id="edit{{$payment_method->id}}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit payment method</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        {!! Form::model($payment_method,[
                        'route'=>['payment.update',$payment_method->id],
                        'method'=>'patch',
                        ]) !!}

                        <div class="form-group">
                            <label for="name">Edit payment method</label>
                            <br>
                            {!! Form::text('name',null,
                            ['class'=>'form-control',
                            'placeholder'=>'Enter payment method']) !!}

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
        <div class="modal" tabindex="-1" role="dialog" id="delete{{$payment_method->id}}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">

                        {!! Form::model($payment_method,[
                        'route'=>['payment.destroy',$payment_method->id],
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



