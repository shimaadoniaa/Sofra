@extends('layouts.app')

@inject('client','App\Model\Client')
@inject('order','App\Model\Order')
@inject('rate','App\Model\Comment')

@section('head','home')

@section('content')

  @section('page_title','Dashboard')

  <section class="content">

        <div class="row">

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">client</span>
                        <span class="info-box-number">{{$client->count()}}</span>
                    </div>
                </div>
            </div>


            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-star-half-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">rate</span>
                        <span class="info-box-number">{{$rate->avg('rate')}}</span>
                    </div>
                </div>
            </div>


            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-arrow-alt-circle-up"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">orders</span>
                        <span class="info-box-number">{{$order->count()}}</span>
                    </div>
                </div>
            </div>


        </div>


        <!-- Default box -->
        <div class="card">
            <div class="card-header">


                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

               @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{ __('You are logged in!') }}
            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>

@endsection
