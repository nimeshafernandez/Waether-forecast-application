@extends('layouts.admin')

@section('content')

<brand-management-component :super_admin="{{json_encode($super_admin)}}" :warehouse_id="{{$warehouse_id}}">
</brand-management-component>

@endsection

@section('css')

@endsection

@section('js')

@endsection