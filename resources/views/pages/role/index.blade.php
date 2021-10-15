@extends('layouts.admin')

@section('content')

<div class="row layout-top-spacing mb-4">
    <div class="col-lg-12">
        <div class="card component-card_1">
            <div class="card-body">
                <h5 class="card-title">Add New User Type</h5>
                <div class="col-lg-12 mt-4">
                    <form method="POST" action="{{route('roles.store')}}">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="name">Role Name</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Specify the role name" required>
                                </div>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Add</button>
                        <button type="reset" class="btn btn-danger mt-2">Reset</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 my-3">
        <div class="card component-card_1">
            <div class="card-body">
                <h5 class="card-title">Roles & Permission Overview</h5>
                <div class="row pt-3">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-condensed mb-4">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <th>001</th>
                                    <th>Nimesha</th>
                                    <th>All Permissions</th>
                                    <th>Super Admin</th>
                                </tr>
                                <tr>
                                    <th>002</th>
                                    <th>Tharika</th>
                                    <th>All Permissions</th>
                                    <th>New Admin</th>
                                </tr>
                                <tr>
                                    <th>003</th>
                                    <th>kawushalya</th>
                                    <th>All Permissions</th>
                                    <th>Super Admin</th>
                                </tr>
                                <tr>
                                    <th>004</th>
                                    <th>rusiru</th>
                                    <th>Non Permissions</th>
                                    <th>Super Admin</th>
                                </tr>
                                {{-- <tbody>
                                    @foreach ($roles as $index=>$rl)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$rl->name}}</td>
                                        <td>
                                            @foreach ($rl->permissions()->get() as $per)
                                            <div class="d-flex inline">
                                                <i class="fas fa-caret-right text-success mr-3"
                                                    style="font-size: 1.5rem"></i>
                                                <p>{{ ucwords(str_replace('_', ' ', $per->name)) }}</p>
                                            </div>
                                            @endforeach
                                        </td>
                                        <td style="vertical-align: middle; text-align: center"><a
                                                class="fa fa-edit text-primary" href="{{route('roles.show', $rl->id)}}">
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody> --}}

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
