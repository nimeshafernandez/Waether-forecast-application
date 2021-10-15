@extends('layouts.admin')

@section('content')

<div class="row layout-top-spacing mb-4">
    <div class="col-lg-12">
        <div class="card component-card_1">
            <div class="card-body">
                <h5 class="card-title">Users Overview</h5>
                <div class="row pt-3">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-condensed mb-4">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->getRoleNames()[0]}}</td>
                                        <td style="vertical-align: middle; text-align: center">
                                            @if($user->getRoleNames()[0] == "Super Admin")
                                            @if(Auth::user()->getRoleNames()[0] == "Super Admin")
                                            <a class="fa fa-eye text-success" href="{{route('user.show', $user->id)}}">
                                            </a>
                                            @endif
                                            @else
                                            <a class="fa fa-eye text-success" href="{{route('user.show', $user->id)}}">
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection