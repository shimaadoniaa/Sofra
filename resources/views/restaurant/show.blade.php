@extends('layouts.app')
@section('head','show')
@section('page_title','restaurant')
@section('content')

    <div class="card-body">
        @include('partials.validation_errors')
        @if($restaurant)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td >restaurant</td>
                        <td class="col sm-3">{{$restaurant->restaurant_name}}</td>
                    </tr>
                    <tr>
                        <td>phone</td>
                        <td>{{$restaurant->phone}}</td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td>{{$restaurant->email}}</td>
                    </tr>
                    <tr>
                        <td>status</td>
                        <td>{{$restaurant->status}}</td>
                    </tr>
                    <tr>
                        <td>distriction</td>
                        <td>{{$restaurant->distriction->name}}</td>
                    </tr>
                    <tr>
                        <td>minimum_order</td>
                        <td>{{$restaurant->minimum_order}}</td>
                    </tr>
                    <tr>
                        <td>img</td>
                        <td>{{$restaurant->img}}</td>
                    </tr>
                    <tr>
                        <td>whatsApp</td>
                        <td>{{$restaurant->whatsApp}}</td>
                    </tr>
                    <tr>
                        <td>rate</td>
                        <td>{{$restaurant->rate}}</td>
                    </tr>

                    <tr>
                        <td>delivery_fees</td>
                        <td>{{$restaurant->delivery_fees}}</td>
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






