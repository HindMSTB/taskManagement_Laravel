@extends('layouts.app2')
@extends('layouts.message')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Détails de la tâche : {{ $tache->titre }}</div>

                <div class="card-body">
                    <p><strong>Créé par :</strong> {{ $createurName }}</p>
                 
                    <p><strong>Description :</strong> {{ $tache->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
