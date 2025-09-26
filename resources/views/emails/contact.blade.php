{{-- resources/views/emails/contact.blade.php --}}
@extends('layouts.app')


@section('title', 'Contact - KDWF')

@section('content')


    <p><strong>Nom :</strong> {{ $data['prenom'] }} {{ $data['nom'] }}</p>
    <p><strong>Email :</strong> {{ $data['email'] }}</p>
    <p><strong>Téléphone :</strong> {{ $data['telephone'] }}</p>
    <p><strong>Message :</strong></p>
    <p>{{ $data['message'] }}</p>

@endsection