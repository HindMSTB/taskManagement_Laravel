@extends('layouts.app4')

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


    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Créer un compte') }}</div>
                <div class="card-body">
                    <form action="{{ route('ajouterCompte') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nom') }}</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Entrez le nom de l'utilisateur" required>
                        </div>
                        <div class="mb-3">
                            <label for="dateNaissance" class="form-label">{{ __('Date de naissance') }}</label>
                            <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" required>
                        </div>
                        <div class="mb-3">
                            <label for="adresse" class="form-label">{{ __('Adresse') }}</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Entrez l'adresse" required>
                        </div>
                        <div class="mb-3">
                            <label for="num" class="form-label">{{ __('Numéro de téléphone') }}</label>
                            <input type="text" class="form-control" id="num" name="num" placeholder="Entrez le numéro de téléphone" required>
                        </div>
                        <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Adresse email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Entrez l'adresse email" required>
                        @php
                            use App\Models\User;
                            $emailExists = User::where('email', old('email'))->exists();
                        @endphp
                        @if ($emailExists)
                        <div class="alert alert-danger text-red-500" role="alert">
                                {{ __('Cette adresse email est déjà utilisée.') }}
                            </div>
                        @endif
                    </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Entrez le mot de passe" required>
                        </div>
                        <div class="mb-3">
                            <label for="usertype" class="form-label">{{ __('Type d\'utilisateur') }}</label>
                            <select class="form-control" id="usertype" name="usertype" required>
                                <option value="user">Utilisateur normal </option>
                                <option value="admin">Administrateur</option>
                                <option value="moderateur">Modérateur</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Ajouter le compte') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

@endsection
