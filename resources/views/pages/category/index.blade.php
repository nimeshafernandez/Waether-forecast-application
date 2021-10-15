@extends('layouts.admin')

@section('content')

<category-management-component :super_admin="{{json_encode($super_admin)}}" :warehouse_id="{{$warehouse_id}}">
</category-management-component>

@endsection

@section('css')

@endsection

@section('js')

@endsection