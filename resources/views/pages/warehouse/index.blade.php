@extends('layouts.admin')

@section('content')

<div class="row layout-top-spacing mb-4">
    <div class="col-lg-12">
        <div class="card component-card_1">
            <div class="card-body">
                <h5 class="card-title">Add Warehouse</h5>
                <div class="col-lg-12">
                    <form method="POST" action="{{route('warehouse.store')}}">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="name">Warehouse Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Warehouse Name"
                                        required>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" name="location"
                                        placeholder="Warehouse Location" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="add_product" class="btn btn-primary mt-2">Add</button>
                        <button type="reset" class="btn btn-danger mt-2">Reset</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 my-3">
        <div class="card component-card_1">
            <div class="card-body">
                <h5 class="card-title">Warehouse Overview</h5>
                <div class="row pt-3">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-condensed mb-4">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($warehouses as $wh)
                                    <tr>
                                        <td>{{$wh->id}}</td>
                                        <td>{{$wh->name}}</td>
                                        <td>{{$wh->location}}</td>
                                        <td><i class="fas fa-edit"></i></td>
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