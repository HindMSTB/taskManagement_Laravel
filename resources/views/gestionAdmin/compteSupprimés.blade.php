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

    <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Comptes Supprimés</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nom et Prénom</th>
                            <th>Email</th>
                            <th>Type de compte</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
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
              
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmRecoverModal{{ $compte->id }}">Récupérer</a>
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

@foreach($listeComptes as $compte)

       

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

                            <li class="list-group-item"><strong>Suppression par :</strong>
                              
                                    @php
                                        $supprimeur = App\Models\User::find($compte->deletedBy);
                                        $supprimeurName = $supprimeur ? $supprimeur->name : 'N/A';
                                    @endphp
                                    {{ $supprimeurName }}
                           
                            </li>
                            <li class="list-group-item"><strong>Date et heure de suppression :</strong> {{ $compte->dateSuppression }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

<!-- Modal Récupération -->
<div class="modal fade" id="confirmRecoverModal{{ $compte->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmRecoverModalLabel{{ $compte->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmRecoverModalLabel{{ $compte->id }}">Confirmer la récupération</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir récupérer le compte de {{ $compte->name }} ({{ $compte->email }}) ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <form action="{{ route('recupererCompte', $compte->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Récupérer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


 
    @endforeach



@endsection
