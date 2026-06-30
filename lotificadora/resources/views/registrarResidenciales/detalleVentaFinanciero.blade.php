@extends('layouts.app')

@section('content')

<detalle-venta-financiero-component :data="{{ json_encode($data) }}"></detalle-venta-financiero-component>

@endsection
