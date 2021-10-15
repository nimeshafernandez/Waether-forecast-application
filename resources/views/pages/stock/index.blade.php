@extends('layouts.admin')

@section('content')
<stock-overview-component :super_admin="{{json_encode($super_admin)}}" :warehouse_id="{{$warehouse_id}}" />
@endsection

@section('css')

@endsection

@section('js')

@endsection