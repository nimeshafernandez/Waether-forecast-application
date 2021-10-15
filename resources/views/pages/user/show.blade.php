@extends('layouts.admin')

@section('content')

<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">


                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="card component-card_2">
                            <img src="../assets/img/400x300.jpg" class="card-img-top" alt="widget-card-2">
                            <div class="card-body">
                                <h5 class="card-title pb-1"><strong>{{$user->name}}</strong></h5>
                                <h6>Role : {{$user->getRoleNames()[0]}}</h6>
                                <h6>Member Since : {{$user->created_at->diffForHumans()}}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-sm-12">
                        <div class="col py-2">
                            <div class="card component-card_1">
                                <div class="card-body">
                                    <h5 class="card-title">User Information</h5>
                                    <div class="col">

                                        <div class="row">
                                            <label style="font-weight: bold; padding-right:10px;">Name :</label>
                                            <label class="">{{$user->name}}</label>
                                        </div>

                                        <div class="row">
                                            <label style="font-weight: bold; padding-right:10px;">Email :</label>
                                            <label>{{$user->email}}</label>
                                        </div>
                                        <div class="row">
                                            <label style="font-weight: bold; padding-right:10px;">Username
                                                :</label> <label>{{$user->username}}</label>
                                        </div>
                                        <div class="row">
                                            <label style="font-weight: bold; padding-right:10px;">Warehouse
                                                :</label> <label>
                                                @if ($user->warehouse != null )
                                                {{$user->warehouse->name}}
                                                @else
                                                Unassigned
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col py-2">
                            <div class="card component-card_1">
                                <div class="card-body">
                                    <h5 class="card-title">Actions</h5>
                                    <div class="pt-2">
                                        <edit-user-module :user_id="{{$user->id}}"
                                            :logged_user_id="{{Auth::user()->id}}"
                                            :current_role_id="{{$user->roles->pluck('id')}}"></edit-user-module>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')

@endsection

@section('js')

@endsection