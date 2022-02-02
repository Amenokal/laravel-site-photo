@extends('errors.error-layout')

@section('content')

    <h1>404</h1>
    <p>La page demandée n'existe pas</p>
    <a href="{{route('home')}}"><i class="fa fa-chevron-left"></i>Retour à la page d'accueil</a>

@endsection
