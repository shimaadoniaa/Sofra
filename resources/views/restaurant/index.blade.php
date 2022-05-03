@extends('layouts.app')
@section('head','index')
@section('page_title','Restaurants')
@section('content')

    <div class="card-body">

        {!! Form::open(['method'=>'GET','route'=>'restaurant.index','role'=>'search'])  !!}

        <div class="row">

            <div class="col-sm-12">
                {!! Form::select('distriction_id',App\Model\Distriction::pluck('name' ,'id')->toArray(),request('distriction_id'),[
                  'class' => 'form-control',
                  'placeholder' => 'select distriction'
                  ])!!}
            </div>
            <br>
            <br>
            <div class="col-sm-12">
            {!! Form::text('search_by_name',request('search_by_name'),[
              'class'=>'form-control',
              'placeholder'=>'enter name'
               ])  !!}

            </div>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i></button>

            </div>
         </div>
        {!! Form::close()!!}


        @include('partials.validation_errors')
        @if(count($restaurants))
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    {{--                    <th scope="col">order</th>--}}
                    <th scope="col">restaurant</th>
                    <th scope="col">client</th>
                    <th scope="col">price</th>
                    <th >process</th>

                </tr>
                </thead>
                <tbody>
                <?php $i=0; ?>
                @foreach($restaurants as $restaurant)
                    <?php $i++ ?>
                    <tr>
                        <td>{{$i}}</td>
                        {{--                        <td>{{$order->name}}</td>--}}
                        <td>{{$restaurant->restaurant_name}}</td>
                        <td>{{$restaurant->email}}</td>
                        <td>{{$restaurant->phone}}</td>
                        <td>{{$restaurant->status}}</td>
                        <td>
                            @can('DeleteRestaurant')
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete{{$restaurant->id}}" title="Delete" >
                                <i class="fa fa-trash"></i></button>
                            @endcan

                            @can('ShowRestaurant')
                            <a type="submit" href="{{route('restaurant.show',$restaurant->id)}}" class="btn btn-danger btn-sm"  title="Delete" >
                                <i class="fa fa-show"></i>Show</a>
                            @endcan
                        </td>
                    </tr>

                    {{--          Delete Modal                    --}}
                    <div class="modal" tabindex="-1" role="dialog" id="delete{{$restaurant->id}}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Delete</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">

                                    {!! Form::model($restaurant,[
                                    'route'=>['restaurant.destroy',$restaurant->id],
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






