@extends('layouts.app4')

@section('content')
    @if (session('success'))
        <!-- Affichage du message de succès -->
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
        <!-- Card pour la liste des comptes -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Liste des Comptes</h6>
            </div>
            <div class="card-body">
                <!-- Tableau responsive pour afficher les comptes -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <!-- Entête du tableau -->
                        <thead>
                            <tr>
                                <th>Nom et Prénom</th>
                                <th>Email</th>
                                <th>Type de compte</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <!-- Corps du tableau -->
                        <tbody>
                            <!-- Boucle pour afficher les comptes -->
                            @foreach($listeComptes as $compte)
                                <tr>
                                    <td>{{ $compte->name }}</td>
                                    <td>{{ $compte->email }}</td>
                                    <td>{{ $compte->usertype }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h fa-xs"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modifyModal{{ $compte->id }}">Modifier</a>

                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDeleteModal{{ $compte->id }}">Supprimer</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailsModal{{ $compte->id }}">Détails</a>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#historyModal{{ $compte->id }}">Historique</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals de modification, de détails et d'historique pour chaque compte -->
    @foreach($listeComptes as $compte)
        <!-- Modal Modifier -->
        <div class="modal fade" id="modifyModal{{ $compte->id }}" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel{{ $compte->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modifyModalLabel{{ $compte->id }}">Modifier le compte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulaire de modification du compte -->
                        <form action="{{ route('modifierCompte', $compte->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Nom et Prénom</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $compte->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $compte->email }}">
                            </div>
                            <div class="form-group">
                                <label for="dateNaissance">Date de Naissance</label>
                                <input type="date" class="form-control" id="dateNaissance" name="dateNaissance" value="{{ $compte->dateNaissance }}">
                            </div>
                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="{{ $compte->adresse }}">
                            </div>
                            <div class="form-group">
                                <label for="num">Numéro de Téléphone</label>
                                <input type="text" class="form-control" id="num" name="num" value="{{ $compte->num }}">
                            </div>
                            <div class="form-group">
                                <label for="usertype">Type de compte</label>
                                <select class="form-control" id="usertype" name="usertype">
                                    <option value="user" {{ $compte->usertype == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                    <option value="admin" {{ $compte->usertype == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                    <option value="moderateur" {{ $compte->usertype == 'moderateur' ? 'selected' : '' }}>Modérateur</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Modifier le mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Entrez un nouveau mot de passe">
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Détails -->
        <div class="modal fade" id="detailsModal{{ $compte->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $compte->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel{{ $compte->id }}">Détails du compte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Nom et Prénom:</strong> {{ $compte->name }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $compte->email }}</li>
                            <li class="list-group-item"><strong>Date de Naissance:</strong> {{ $compte->dateNaissance }}</li>
                            <li class="list-group-item"><strong>Adresse:</strong> {{ $compte->adresse }}</li>
                            <li class="list-group-item"><strong>Numéro de Téléphone:</strong> {{ $compte->num }}</li>
                            <li class="list-group-item"><strong>Type de compte:</strong> {{ $compte->usertype }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

               
        
        <!-- Modal Historique -->
        <div class="modal fade" id="historyModal{{ $compte->id }}" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel{{ $compte->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="historyModalLabel{{ $compte->id }}">Historique du compte</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Date et heure de création:</strong> {{ $compte->dateCreation }}</li>
                            <li class="list-group-item"><strong>Créé par:</strong>
                            @if ($compte->createdBy == 'inscription')
                                    Inscription
                                @else
                                <?php
                    $createurId = $compte->createdBy;
                    $createur = App\Models\User::findOrFail($createurId);
                    $createurName = $createur->name; ?>
                                    {{  $createurName }}
                                @endif
                            </li>

                            <li class="list-group-item"><strong>Date et heure de vérification de Email :</strong> {{ $compte->email_verified_at }}</li>
                            <li class="list-group-item"><strong>Dernière modification par:</strong>
                            @if ($compte->modifiedBy == Null)
                                    pas encore modifié
                                @else
                                <?php
                    $modifierId = $compte->modifiedBy;
                    $modifier = App\Models\User::findOrFail($modifierId);
                    $modifierName = $modifier->name; ?>
                                    {{  $modifierName }}
                             
                            </li>
                            <li class="list-group-item"><strong>date et heure :</strong> {{ $compte->dateModification }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
   

    <div class="modal fade" id="confirmDeleteModal{{ $compte->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel{{ $compte->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel{{ $compte->id }}">Confirmation de suppression</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer le compte de {{ $compte->name }} ({{ $compte->email }}) ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <form action="{{ route('supprimerCompte', $compte->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


  @endforeach
@endsection
