@extends('layouts.app')

@section('content')
    <morosos-detalle-component :resumenmorosos="{{ json_encode($data[0]) }}"></morosos-detalle-component>
@endsection
