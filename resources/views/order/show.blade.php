@extends('layouts.app')
@section('head','show')
@section('page_title','order details')
@section('content')

    <div class="card-body">
        @include('partials.validation_errors')
        @if($order)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td >restaurant</td>
                        <td class="col sm-3">{{$order->restaurant->restaurant_name}}</td>
                    </tr>
                    <tr>
                        <td>client</td>
                        <td>{{$order->Client->name}}</td>
                    </tr>
                    <tr>
                        <td>note</td>
                        <td>{{$order->note}}</td>
                    </tr>
                    <tr>
                        <td>address</td>
                        <td>{{$order->address}}</td>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>{{$order->status}}</td>
                    </tr>
                    <tr>
                        <td>price</td>
                        <td>{{$order->price}}</td>
                    </tr>
                    <tr>
                        <td>commission</td>
                        <td>{{$order->commission}}</td>
                    </tr>
                    <tr>
                        <td>total</td>
                        <td>{{$order->total}}</td>
                    </tr>
                   <tr>
                        <td>paymentmethod</td>
                        <td>{{$order->payment->name}}</td>
                    </tr>

                </table>
            </div>
        @else
            <div class="alert alert.danger" role="alert">
                No Data
            </div>
        @endif
    </div>

@endsection





