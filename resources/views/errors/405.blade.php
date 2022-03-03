@extends('errors.error-layout')

@section('content')

    <h1>403</h1>
    <p>Veuillez vous connecter pour procéder à cette action</p>
    <span>
        <a href="{{route('admin')}}">Se connecter</a>
        <i class="fa fa-chevron-right"></i>
    </span>
    <span>
        <i class="fa fa-chevron-left"></i>
        <a href="{{route('home')}}">Retour à la page d'accueil</a>
    </span>


@endsection
