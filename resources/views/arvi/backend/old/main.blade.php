@extends('arvi.layouts.main')

@section('content')

<style>
    .scrollit {
        border: 1px black solid;
        margin-top:1000px;
    }
    .scrollable{
        overflow-y:scroll;
        max-height:450px;
    }
    #header-fixed {
        position: fixed;
        top: 0px; display:none;
        background-color:white;
    }
    .outside{
        padding: 100px;
    }
    th,td{
        font-size: 12px;
        text-align: center;
    }
    td.align-left{
        text-align: left;
        
    }
</style>


<div class="outside p-5">

    @auth    
        <h1 class="text-center">DashBoard</h1>
        <h3 class="text-center">Hello, {{ auth()->user()->name }}</h1>

        
        @if (session()->has('success'))
            <div class="row">
                <div class="col">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <form action="{{ route('logout-dashboard',['qrCode' => 'mrcasdfghjkl']) }}" method="post">
                @csrf
                <div class="col-3">
                    <button type="submit">logout</button>
                </div>
            </form>
        </div>

        <div class="row mt-5">
            <div class="col">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    {{-- <li class="nav-item  tabButton" role="presentation">
                        <button class="nav-link tabButton" id="home-tab" data-name="home" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Home</button>
                    </li> --}}
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tabButton" id="order-tab" data-name="order" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab-pane" aria-selected="false">Order</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tabButton" id="productionPlan-tab" data-name="productionPlan" data-bs-toggle="tab" data-bs-target="#productionPlan-tab-pane" type="button" role="tab" aria-controls="productionPlan-tab-pane" aria-selected="false">Production Plan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tabButton" id="deliveryDropPoint-tab" data-name="deliveryDropPoint" data-bs-toggle="tab" data-bs-target="#deliveryDropPoint-tab-pane" type="button" role="tab" aria-controls="deliveryDropPoint-tab-pane" aria-selected="false">Delivery Drop Point</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link tabButton" id="product-tab" data-name="product" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="false">List Product</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    {{-- <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">@include('arvi.backend.index')</div> --}}
                    <div class="tab-pane fade show active" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab" tabindex="0">@include('arvi.backend.orderList')</div>
                    <div class="tab-pane fade" id="productionPlan-tab-pane" role="tabpanel" aria-labelledby="productionPlan-tab" tabindex="0">@include('arvi.backend.productionPlanList')</div>
                    <div class="tab-pane fade" id="deliveryDropPoint-tab-pane" role="tabpanel" aria-labelledby="deliveryDropPoint-tab" tabindex="0">@include('arvi.backend.deliveryDropPointList')</div>
                    <div class="tab-pane fade" id="product-tab-pane" role="tabpanel" aria-labelledby="product-tab" tabindex="0">@include('arvi.backend.productList')</div>
                </div>
            </div>
        </div>
    @else

    <div class="container">
        <div class="row">
            <div class="col">
                
                @if (session()->has('error'))
                <div class="row">
                    <div class="col">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                @endif
    
    
                <div class="row mt-5">
                    <div class="col-5 m-auto">
                        <h1 class="text-center">Login</h1>
    
                        <form action="{{route('login',['qrCode' => $qrCode])}}" method="POST">
    
                            @csrf
    
                            @if (session()->has('loginError'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ session('loginError') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                                </div>
                            @endif
    
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="email.." autofocus required value="{{old('email')}}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
    
                            <div class="form-group mt-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="password.." required>
                            </div>
    
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
    
                        </form>
    
                    </div>
                </div>
                    
            </div>
    </div>

    @endauth
    

</div>


@endsection