@extends('layouts.app')
@section('head','index')
@section('page_title','Offer')
@section('content')

    <div class="card-body">

        {!! Form::open(['method'=>'GET','route'=>'offer.index','class'=>'navbar-form navbar-left','role'=>'search'])  !!}

        <div class="row">

            <div class="col-sm-3">
                {!! Form::select('restaurant_id',App\Model\Restaurant::pluck('restaurant_name' ,'id')->toArray(),request('restaurant_id'),[
                  'class' => 'form-control',
                  'placeholder' => 'select restaurant'
                  ])!!}
            </div>

            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i> search</button>
            </div>

        </div>
        {!! Form::close()!!}

        @include('partials.validation_errors')
        @if(count($offers))
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    {{--                    <th scope="col">order</th>--}}
                    <th scope="col">restaurant</th>
                    <th scope="col">img</th>
                    <th scope="col">content</th>
                    <th scope="col">from_date</th>
                    <th scope="col">to_date</th>
                    <th >process</th>

                </tr>
                </thead>
                <tbody>
                <?php $i=0; ?>
                @foreach($offers as $offer)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$offer->restaurant->restaurant_name}}</td>
                        <td><img src="{{asset($offer->img)}}" style="high:100px;width:100px"></td>
                        <td>{{$offer->content}}</td>
                        <td>{{$offer->from_date}}</td>
                        <td>{{$offer->to_date}}</td>
                        <td>
                            @can('DeleteOffer')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$offer->id}}" title="Delete" >
                                <i class="fa fa-trash"></i></button>
                            @endcan
                        </td>
                    </tr>

                    {{--          Delete Modal                    --}}
                    <div class="modal" tabindex="-1" role="dialog" id="delete{{$offer->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {!! Form::model($offer,[
                                    'route'=>['offer.destroy',$offer->id],
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






