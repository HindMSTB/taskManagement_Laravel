@extends('layouts.app2')

@section('content')

@if (session('success'))
    <div id="successAlert" class="position-absolute w-100 text-center" style="top: -3; z-index: 9999;">
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="opacity: 2; background-color: rgba(46, 234, 113, 0.5);">
            <span style="color: white;">{{ session('success') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <script>
        setTimeout(function() {
            $('#successAlert').fadeOut('slow');
        }, 1300);
    </script>
@endif

<!-- Begin Page Content -->
<div class="container-fluid">
<div class="d-sm-flex align-items-center justify-content-between mb-4">
      
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>
    
  
    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ajouter un ticket') }}</div>
                <div class="card-body">
                <form action="{{ route('ajouterTache') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="titre" class="form-label">{{ __('Titre') }}</label>
        <input type="text" class="form-control" id="titre" name="titre" placeholder="Entrez le titre de la tâche" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">{{ __('Description') }}</label>
        <textarea class="form-control" id="description" name="description" placeholder="Entrez la description de la tâche" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="dateDue" class="form-label">{{ __('Date d\'échéance') }}</label>
        <input type="date" class="form-control" id="dateDue" name="dateDue" required>
    </div>
    <div class="mb-3">
        <label for="priorite" class="form-label">{{ __('Priorité de la tâche') }}</label>
        <select class="form-control" id="priorite" name="priorite">
            <option value="faible">Faible</option>
            <option value="moyenne">Moyenne</option>
            <option value="forte">Forte</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">{{ __('Ajouter la tâche') }}</button>
</form>

<!-- /.container-fluid -->
@endsection
