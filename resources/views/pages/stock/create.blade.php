@extends('layouts.admin')

@section('content')
<add-stock-component :super_admin="{{json_encode($super_admin)}}" :warehouse_id="{{$warehouse_id}}"
    :max_dropdown="{{config('company.dropdown_results_max')}}" :user_id="{{$user_id}}">
</add-stock-component>
@endsection

@section('css')

@endsection

@section('js')

@endsection