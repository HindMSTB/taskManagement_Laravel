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
                <h6 class="m-0 font-weight-bold text-primary">Liste des taches supprimées</h6>
            </div>
            <div class="card-body">
                <!-- Tableau responsive pour afficher les comptes -->
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <!-- Entête du tableau -->
                        <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Description</th>
                                            <th>Date d'échéance</th>
                                            <th>Priorité</th>
                                            <th>Actions</th> 
                                        </tr>
                                    </thead>
                                    <!-- Corps du tableau -->
                                    <tbody>
                                        <!-- Boucle pour afficher les tâches non affectées -->
                                        @foreach($tacheSupprimées as $tache)
                                        <tr>
                                            <td>{{ $tache->titre }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($tache->description, 100) }}</td>
                                            <td>{{ $tache->dateDue }}</td>
                                            <td>{{ $tache->priorite }}</td>
                                            <td>

                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h fa-xs"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#recupererModal{{ $tache->id }}">Récupérer</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailsModal{{ $tache->id }}">Details</a>

                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#historiqueModalTER{{ $tache->id }}">Historique</a>

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

    @foreach($tacheSupprimées as $tache)
        <div class="modal fade" id="detailsModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel{{ $tache->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel{{ $tache->id }}"><span style="color:black;font-weight: bold;">Détails de la tâche terminée : </span>{{ $tache->titre }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                 
                    $createurId = $tache->createdBy;
                    $createur = App\Models\User::findOrFail($createurId);
                    $createurName = $createur->name;

                    ?>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Créé par :</span></strong> {{ $createurName }}</li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Date et heure de création :</span></strong> {{ $tache->dateCreation }}</li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Date d'échéance :</span></strong> {{ $tache->dateDue }}</li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Affecté à :</span></strong> 
                                @if ($tache->user_id)
                                    <?php
                                        $userName = App\Models\User::findOrFail($tache->user_id)->name;
                                    ?>
                                    {{ $userName }}
                                @else
                                    <span style="color: red;">Pas encore affecté</span>
                                @endif
                            </li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Date et heure d'affectation :</span></strong> 
                                @if ($tache->dateAffectation)
                                    {{ $tache->dateAffectation }}
                                @else
                                    <span style="color: red;">Pas encore affecté</span>
                                @endif
                            </li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Marquée comme Terminée Le :</span></strong> 
                                @if ($tache->DateFin)
                                    {{ $tache->DateFin }}
                                    @if(\Carbon\Carbon::parse($tache->DateFin)->isPast())
                                        <span style="color: red;">(En retard de {{ \Carbon\Carbon::parse($tache->DateFin)->diffInDays() }} jours)</span>
                                    @else
                                        <span>(Terminée {{ \Carbon\Carbon::parse($tache->DateFin)->diffInDays($tache->dateDue) }} jours avant la date d'échéance)</span>
                                    @endif
                                @else
                                    <span style="color: red;">Pas encore terminé</span>
                                @endif
                            </li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Message Fin :</span></strong> 
                                @if ($tache->messageFin)
                                    {{ $tache->messageFin }}
                                @else
                                    <span style="color: red;">Pas encore terminé</span>
                                @endif
                            </li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Titre :</span></strong> {{ $tache->titre }}</li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Description :</span></strong> {{ $tache->description }}</li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">Priorité :</span></strong> {{ $tache->priorite }}</li>
                            <li class="list-group-item"><strong><span style="color: blue; font-weight: bold;">État :</span></strong> {{ $tache->etat }}</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
   
 
    <div class="modal fade custom-modal" id="historiqueModalTER{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="historiqueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-dialog" role="document">
            <div class="modal-content custom-content">
                <div class="modal-header custom-header bg-primary text-white">
                    <h5 class="modal-title" id="historiqueModalLabel">Historique de la tâche : {{ $tache->titre }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Vérifier s'il y a des modifications pour cette tâche -->
                    <?php
                    $modifications = App\Models\Tache::where('tacheOrig', $tache->tacheOrig)->whereNotNull('dateModification')->get();
                    ?>
                    @if($modifications->isEmpty())
                        <p><strong>Création :</strong> {{ $tache->dateCreation }} par {{ $createurName }}</p>
                        <p><strong>Affectée :</strong> {{ $tache->dateAffectation ? $tache->dateAffectation : 'Pas encore affecté' }} à {{ $tache->user_id ? App\Models\User::find($tache->user_id)->name : 'Pas encore affecté' }}</p>
                        <p><strong>Terminée :</strong> 
                            @if ($tache->DateFin)
                                {{ $tache->DateFin }}
                                @if(\Carbon\Carbon::parse($tache->DateFin)->isPast())
                                    <span style="color: red;">(En retard de {{ \Carbon\Carbon::parse($tache->DateFin)->diffInDays() }} jours)</span>
                                @else
                                    <span>(Terminée {{ \Carbon\Carbon::parse($tache->DateFin)->diffInDays($tache->dateDue) }} jours avant la date d'échéance)</span>
                                @endif
                            @else
                                <span style="color: red;">Pas encore terminé</span>
                            @endif
                        </p>
                        <p>Aucune modification n'a encore été apportée à cette tâche.</p>
                    @else
                        <!-- Afficher les détails de création -->
                        <p><strong>Création :</strong> {{ $tache->dateCreation }} par {{ $createurName }}</p>
                        <!-- Afficher les modifications -->
                        <p><strong>Affectée :</strong> 
                            @if ($tache->dateAffectation)
                                {{ $tache->dateAffectation }}
                            @else
                                <span style="color: red;">Pas encore affecté</span>
                            @endif
                            à {{ $tache->user_id ? App\Models\User::find($tache->user_id)->name : 'Pas encore affecté' }}
                        </p>
                        <p><strong>Terminée :</strong> 
                            @if ($tache->DateFin)
                                {{ $tache->DateFin }}
                                @if(\Carbon\Carbon::parse($tache->DateFin)->isPast())
                                    <span style="color: red;">(En retard de {{ \Carbon\Carbon::parse($tache->DateFin)->diffInDays() }} jours)</span>
                                @else
                                    <span>(Terminée {{ \Carbon\Carbon::parse($tache->DateFin)->diffInDays($tache->dateDue) }} jours avant la date d'échéance)</span>
                                @endif
                            @else
                                <span style="color: red;">Pas encore terminé</span>
                            @endif
                        </p>
                        <strong>Modifiée :</strong>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date et heure de modification</th>
                                    <th> par</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modifications as $modification)
                                    <?php
                                    // Récupérer le nom du modificateur
                                    $modifier = App\Models\User::find($modification->modifiedBy);
                                    $modifierName = $modifier ? $modifier->name : "Utilisateur inconnu";
                                    ?>
                                    <tr>
                                        <td>{{ $modification->dateModification }}</td>
                                        <td>{{ $modifierName }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                  
                </div>
                <div class="modal-footer custom-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach($tacheSupprimées as $tache)

    <!-- Modal pour récupérer la tâche supprimée -->
    <div class="modal fade" id="recupererModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="recupererModalLabel{{ $tache->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recupererModalLabel{{ $tache->id }}">Récupérer la tâche : {{ $tache->titre }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir récupérer cette tâche ?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('tache.recuperer', $tache->id) }}">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Récupérer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


    @endsection