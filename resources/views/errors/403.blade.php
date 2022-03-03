@extends('errors.error-layout')

@section('content')

    <h1>403</h1>
    <p>Veuillez vous connecter pour procéder à cette action</p>
    <span>
        <i class="fa fa-chevron-left"></i>
        <a href="{{route('home')}}">Retour à la page d'accueil</a>
    </span>
@endsection
