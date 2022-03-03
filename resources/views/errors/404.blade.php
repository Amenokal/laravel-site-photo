@extends('errors.error-layout')

@section('content')

    <h1>404</h1>
    <p>La page demandée n'existe pas.</p>
    <span>
        <i class="fa fa-chevron-left"></i>
        <a href="{{route('home')}}">Retour à la page d'accueil</a>
    </span>

@endsection
