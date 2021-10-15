@extends('layouts.admin')

@section('content')

<div class="row layout-top-spacing">

    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one pb-3">

                <h5 class="card-title">Add New User</h5>
                <div class="col-lg-12 pt-3">
                    <form method="POST" action="{{route('user.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="formGroupExampleInput">Select Role</label>
                                    <select class="selectpicker form-control" name="role_id">
                                        @foreach ($roles as $rl)
                                        <option value="{{$rl->id}}">{{$rl->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="formGroupExampleInput">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid  @enderror "
                                        placeholder="Name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="formGroupExampleInput">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid  @enderror "
                                        placeholder="Username" name="username" value="{{ old('username') }}">
                                    @error('username')
                                    <div class="invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="formGroupExampleInput">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid  @enderror "
                                        placeholder="Email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="formGroupExampleInput">Password</label>
                                    <input type="password"
                                        class="form-control @error('password') is-invalid  @enderror "
                                        placeholder="Password" name="password">
                                    @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="formGroupExampleInput">Confirm Password</label>
                                    <input type="password"
                                        class="form-control  @error('password') is-invalid  @enderror "
                                        placeholder="Confirm Password" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Add User</button>
                        <button type="reset" class="btn btn-danger mt-3">Reset</button>

                    </form>
                </div>


            </div>
        </div>
    </div>

</div>
@endsection

@section('css')

@endsection

@section('js')
<script>
    var field = document.querySelector('[name="username"]');

    field.addEventListener('keypress', function ( event ) {
    var key = event.keyCode;
        if (key === 32) {
        event.preventDefault();
        }
    });
</script>
@endsection
