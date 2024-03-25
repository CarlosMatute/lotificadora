@extends('layouts.app')

@section('content')

<resumen-venta-lote-vendido-component :resumenventa="{{ json_encode($data[0]) }}"></resumen-venta-lote-vendido-component>

@endsection