@extends('errors.error-layout')

@section('content')

    <h1>403</h1>
    <p>Veuillez vous connecter pour procéder à cette action</p>
    <a href="{{route('admin')}}">Se connecter</a>
    <a href="{{route('home')}}"><i class="fa fa-chevron-left"></i>Retour à la page d'accueil</a>

@endsection
