@extends('layouts.admin')

@section('content')
<view-all-products-component :super_admin="{{json_encode($super_admin)}}" :warehouse_id="{{$warehouse_id}}">
</view-all-products-component>
@endsection

@section('css')

@endsection

@section('js')

@endsection