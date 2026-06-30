@extends('layouts.app')

@section('content')

<resumen-financiero-component :data="{{ json_encode($data) }}"></resumen-financiero-component>

@endsection
