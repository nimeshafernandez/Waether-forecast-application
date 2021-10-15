@extends('layouts.admin')

@section('content')

<add-product-component :super_admin="{{json_encode($super_admin)}}" :warehouse_id="{{$warehouse_id}}">
</add-product-component>

@endsection

@section('css')

@endsection

@section('js')

@endsection