@extends('layouts.admin')

@section('content')

<div class="row layout-top-spacing mb-4">
    <div class="col-lg-12">
        <div class="card component-card_1">
            <div class="card-body">
                <h5 class="card-title">Role: {{$role->name}}</h5>
                <div class="col-lg-12 mt-4">
                    <h6>Number of users for the current role: <strong>{{$users_per_role}}</strong></h6>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 my-3">
        <role-permissions-component :role_id={{$role->id}}></role-permissions-component>
    </div>

</div>
@endsection