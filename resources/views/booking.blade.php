@extends('layout')

@section('title', 'Formulir Pemesanan')

@section('content')
<livewire:booking-form :package_id="(int) request('package_id', 0)" />
@endsection