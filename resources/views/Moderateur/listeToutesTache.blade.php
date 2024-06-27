@extends('layouts.app3')
@extends('layouts.message')

<!-- Affichage du message de succès -->
@section('content')
<!-- Affichage du message de succès -->
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
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- Page Heading content -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Content Column -->
        <div class="col-lg-12 mb-4">
            <!-- Content -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des taches </h6>
                </div>
                <div class="card-body">
                    <!-- Tabs nav -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <!-- Nouvel onglet pour les tâches non affectées -->
                        <li class="nav-item">
                            <a class="nav-link active" id="taches-non-affectees-tab" data-toggle="tab" href="#taches-non-affectees" role="tab" aria-controls="taches-non-affectees" aria-selected="true">Tâches non affectées</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="taches-en-cours-tab" data-toggle="tab" href="#taches-en-cours" role="tab" aria-controls="taches-en-cours" aria-selected="false">Tâches en cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="taches-terminees-tab" data-toggle="tab" href="#taches-terminees" role="tab" aria-controls="taches-terminees" aria-selected="false">Tâches terminées</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Onglet pour les tâches non affectées -->
                        <div class="tab-pane fade show active" id="taches-non-affectees" role="tabpanel" aria-labelledby="taches-non-affectees-tab">
                            <!-- Contenu des tâches non affectées -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableNonAffectees" width="100%" cellspacing="0">
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
                                        @foreach($tachesNonAffectees as $tache)
                                        <tr>
                                            <td>{{ $tache->titre }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($tache->description, 100) }}</td>
                                            <td @if(\Carbon\Carbon::parse($tache->dateDue)->isPast()) style="color: red;" @endif>{{ $tache->dateDue }}</td>
                                            <td>{{ $tache->priorite }}</td>
                                            <td>

                                            <div class="dropdown" >
                                                    <button class="btn btn-secondary dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h fa-xs"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modifyModal{{ $tache->id }}">Modifier</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDeleteModal{{ $tache->id }}">Supprimer</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#AffecterModal{{ $tache->id }}">Affecter</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailsModalAff{{ $tache->id }}">Details</a>

                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#historiqueModalAff{{ $tache->id }}">Historique</a>

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Onglet pour les tâches en cours -->
                        <div class="tab-pane fade" id="taches-en-cours" role="tabpanel" aria-labelledby="taches-en-cours-tab">
                            <!-- Contenu des tâches en cours -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableEnCours" width="100%" cellspacing="0">
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
                                        <!-- Boucle pour afficher les tâches en cours -->
                                        @foreach($tachesEnCours as $tache)
                                        <tr>
                                            <td>{{ $tache->titre }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($tache->description, 100) }}</td>
                                            <td @if(\Carbon\Carbon::parse($tache->dateDue)->isPast()) style="color: red;" @endif>{{ $tache->dateDue }}</td>
                                            <td>{{ $tache->priorite }}</td>
                                            <td>

                                            <div class="dropdown" >
                                                    <button class="btn btn-secondary dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h fa-xs"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modifyModal{{ $tache->id }}">Modifier</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDeleteModal{{ $tache->id }}">Supprimer</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#marquerTerminéeModal{{ $tache->id }}">Marquer comme terminée</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailsModal{{ $tache->id }}">Details</a>

                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#historiqueModal{{ $tache->id }}">Historique</a>

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Onglet pour les tâches terminées -->
                        <div class="tab-pane fade" id="taches-terminees" role="tabpanel" aria-labelledby="taches-terminees-tab">
                            <!-- Contenu des tâches terminées -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableTerminees" width="100%" cellspacing="0">
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
                                        <!-- Boucle pour afficher les tâches terminées -->
                                        @foreach($tachesTerminees as $tache)
                                        <tr>
                                            <td>{{ $tache->titre }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($tache->description, 100) }}</td>
                                            <td @if(\Carbon\Carbon::parse($tache->dateDue)->isPast()) style="color: red;" @endif>{{ $tache->dateDue }}</td>
                                            <td>{{ $tache->priorite }}</td>
                                            <td>

                                            <div class="dropdown" >
                                                    <button class="btn btn-secondary dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h fa-xs"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modifyModalF{{ $tache->id }}">Modifier</a>
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#confirmDeleteModal{{ $tache->id }}">Supprimer</a>
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
            </div>
        </div>
    </div>
</div>

@foreach($tachesNonAffectees as $tache)
    <!-- Modal pour afficher les détails de la tâche Non affectée -->
    <div class="modal fade" id="detailsModalAff{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel" ><span style="color:black;font-weight: bold;">Détails de la tâche en cours : </span>{{ $tache->titre }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    // Récupérer l'utilisateur qui a créé la tâche en utilisant l'ID stocké dans createdBy
                    $createurId = $tache->createdBy;
                    $createur = App\Models\User::findOrFail($createurId);
                    $createurName = $createur->name;
              
                    ?>
                    <p><strong><span style="color: blue; font-weight: bold;">Créé par :</span></strong> {{ $createurName }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date et heure de création :</span></strong> {{$tache->dateCreation  }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date d'échéance :</span></strong> {{ $tache->dateDue }}   
                        @if(\Carbon\Carbon::parse($tache->dateDue)->isPast())
                            <span style="color: red;">(En retard de {{ \Carbon\Carbon::parse($tache->dateDue)->diffInDays() }} jours)</span>
                        @else
                            <span>(Il vous reste {{ \Carbon\Carbon::now()->diffInDays($tache->dateDue) }} jours)</span>
                        @endif
                    </p>
                   
                    <p><strong><span style="color: blue; font-weight: bold;">Titre :</span></strong> {{ $tache->titre }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Description :</span></strong> {{ $tache->description }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Priorité :</span></strong> {{ $tache->priorite }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Etat :</span></strong> en attente d'affectation</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach($tachesEnCours as $tache)
    <!-- Modal pour afficher les détails de la tâche en cours -->
    <div class="modal fade" id="detailsModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel" ><span style="color:black;font-weight: bold;">Détails de la tâche en cours : </span>{{ $tache->titre }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    // Récupérer l'utilisateur qui a créé la tâche en utilisant l'ID stocké dans createdBy
                    $createurId = $tache->createdBy;
                    $createur = App\Models\User::findOrFail($createurId);
                    $createurName = $createur->name;
                  
                    $userName = App\Models\User::findOrFail($tache->user_id)->name;
                    ?>
                    <p><strong><span style="color: blue; font-weight: bold;">Créé par :</span></strong> {{ $createurName }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date et heure de création :</span></strong> {{$tache->dateCreation  }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date d'échéance :</span></strong> {{ $tache->dateDue }}   
                        @if(\Carbon\Carbon::parse($tache->dateDue)->isPast())
                            <span style="color: red;">(En retard de {{ \Carbon\Carbon::parse($tache->dateDue)->diffInDays() }} jours)</span>
                        @else
                            <span>(Il vous reste {{ \Carbon\Carbon::now()->diffInDays($tache->dateDue) }} jours)</span>
                        @endif
                    </p>
                    <p><strong><span style="color: blue; font-weight: bold;">Affecté à :</span></strong> {{  $userName}}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date et heure d'affectation :</span></strong> {{$tache-> dateAffectation}}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Titre :</span></strong> {{ $tache->titre }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Description :</span></strong> {{ $tache->description }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Priorité :</span></strong> {{ $tache->priorite }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Etat :</span></strong> {{ $tache->etat }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

@foreach($tachesTerminees as $tache)
    <!-- Modal pour afficher les détails de la tâche terminées -->
    <div class="modal fade" id="detailsModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel" ><span style="color:black;font-weight: bold;">Détails de la tâche en cours : </span>{{ $tache->titre }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                  
                    $createurId = $tache->createdBy;
                    $createur = App\Models\User::findOrFail($createurId);
                    $createurName = $createur->name;
                  
                    $userName = App\Models\User::findOrFail($tache->user_id)->name;
                    ?>
                    <p><strong><span style="color: blue; font-weight: bold;">Créé par :</span></strong> {{ $createurName }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date et heure de création :</span></strong> {{$tache->dateCreation  }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date d'échéance :</span></strong> {{ $tache->dateDue }}     </p>
                    <p><strong><span style="color: blue; font-weight: bold;">Affecté à :</span></strong> {{  $userName}}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date et heure d'affectation :</span></strong> {{$tache-> dateAffectation}}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Marquée comme Terminée Le :</span></strong> {{ $tache->DateFin }}
                    @if(\Carbon\Carbon::parse($tache->DateFin)->isPast())
                        <span style="color: red;">(En retard de {{ \Carbon\Carbon::parse($tache->DateFin)->diffInDays() }} jours)</span>
                    @else
                        <span>(Terminée {{ \Carbon\Carbon::parse($tache->DateFin)->diffInDays($tache->dateDue) }} jours avant la date d'échéance)</span>
                    @endif
                    </p>

                    <p><strong><span style="color: blue; font-weight: bold;">Message Fin   :</span></strong> {{ $tache->messageFin }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Titre :</span></strong> {{ $tache->titre }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Description :</span></strong> {{ $tache->description }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Priorité :</span></strong> {{ $tache->priorite }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Etat :</span></strong> {{ $tache->etat }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endforeach




<!-- Modal pour afficher l'historique de la tâche Terminée-->

@foreach($tachesTerminees as $tache)
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
                    @php
                        $createurNameT = App\Models\User::find($tache->createdBy)->name ?? 'Utilisateur inconnu';
                        $userNameT = App\Models\User::find($tache->user_id)->name ?? 'Utilisateur inconnu';
                        $modifications = App\Models\Tache::where('tacheOrig', $tache->tacheOrig)->whereNotNull('dateModification')->get();
                    @endphp

                    <p><strong>Créé :</strong> {{ $tache->dateCreation }} par {{ $createurNameT }}</p>
                    <p><strong>Affectée:</strong> {{ $tache->dateAffectation }} à {{ $userNameT }} </p>
                    <p><strong>Terminée :</strong> {{ $tache->DateFin }}</p>

                    @if($modifications->isEmpty())
                        <p>Aucune modification n'a encore été apportée à cette tâche.</p>
                    @else
                        <strong>Modifiée :</strong>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date et heure </th>
                                    <th>Par</th>
                                    <th>Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modifications as $modification)
                                    @php
                                        $modifierName = App\Models\User::find($modification->modifiedBy)->name ?? 'Utilisateur inconnu';
                                    @endphp
                                    <tr>
                                        <td>{{ $modification->dateModification }}</td>
                                        <td>{{ $modifierName }}</td>
                                        <td>{{ $modification->ModifDetails }}</td>
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

@foreach($tachesEnCours as $tache)
    <div class="modal fade custom-modal" id="historiqueModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="historiqueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-dialog" role="document">
            <div class="modal-content custom-content">
                <div class="modal-header custom-header bg-primary text-white">
                    <h5 class="modal-title" id="historiqueModalLabel">Historique de la tâche : {{ $tache->titre }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        // Récupérer les noms des utilisateurs associés
                        $createurName = App\Models\User::find($tache->createdBy)->name ?? 'Utilisateur inconnu';
                        $userName = App\Models\User::find($tache->user_id)->name ?? 'Utilisateur inconnu';
                        $modifications = App\Models\Tache::where('tacheOrig', $tache->tacheOrig)->whereNotNull('dateModification')->get();
                    @endphp

                    <p><strong>Créé :</strong> {{ $tache->dateCreation }} par {{ $createurName }}</p>
                    <p><strong>Affectée:</strong> {{ $tache->dateAffectation }} à {{ $userName }} </p>

                    @if($modifications->isEmpty())
                        <p>Aucune modification n'a encore été apportée à cette tâche.</p>
                    @else
                        <strong>Modifiée :</strong>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date et heure </th>
                                    <th>Par</th>
                                    <th>Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modifications as $modification)
                                    @php
                                        $modifierName = App\Models\User::find($modification->modifiedBy)->name ?? 'Utilisateur inconnu';
                                    @endphp
                                    <tr>
                                        <td>{{ $modification->dateModification }}</td>
                                        <td>{{ $modifierName }}</td>
                                        <td>{{ $modification->ModifDetails }}</td>
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

@foreach($tachesNonAffectees as $tache)
    <div class="modal fade custom-modal" id="historiqueModalAff{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="historiqueModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg custom-dialog" role="document">
            <div class="modal-content custom-content">
                <div class="modal-header custom-header bg-primary text-white">
                    <h5 class="modal-title" id="historiqueModalLabel">Historique de la tâche : {{ $tache->titre }}</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        // Récupérer les noms des utilisateurs associés
                        $createurName = App\Models\User::find($tache->createdBy)->name ?? 'Utilisateur inconnu';
                        $modifications = App\Models\Tache::where('tacheOrig', $tache->tacheOrig)->whereNotNull('dateModification')->get();
                    @endphp

                    <p><strong>Créé :</strong> {{ $tache->dateCreation }} par {{ $createurName }}</p>

                    @if($modifications->isEmpty())
                        <p>Aucune modification n'a encore été apportée à cette tâche.</p>
                    @else
                        <strong>Modifiée :</strong>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date et heure </th>
                                    <th>Par</th>
                                    <th>Détails</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modifications as $modification)
                                    @php
                                        $modifierName = App\Models\User::find($modification->modifiedBy)->name ?? 'Utilisateur inconnu';
                                    @endphp
                                    <tr>
                                        <td>{{ $modification->dateModification }}</td>
                                        <td>{{ $modifierName }}</td>
                                        <td>{{ $modification->ModifDetails }}</td>
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


<!-- Modal de modification -->
@php
$allUsers = App\Models\User::all();

$users = $allUsers->where('status', 1)
     ->whereNotNull('email_verified_at');

                    
   
@endphp

@foreach($toutesLesTaches as $tache)
<div class="modal fade" id="modifyModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyModalLabel">Modifier la tâche</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire de modification -->
                <form action="{{ route('modifierTache', $tache->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" value="{{ $tache->titre }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $tache->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="dateDue">Date d'échéance</label>
                        <input type="date" class="form-control" id="dateDue" name="dateDue" value="{{ $tache->dateDue }}" required>
                    </div>

                    <div class="form-group">
                       
                        <input type="hidden" class="form-control" id="DateFin" name="DateFin" value="{{ $tache->DateFin }}" required>
                    </div>
               
                    
                    <div class="form-group">
                        <label for="priorite">Priorité</label>
                        <select class="form-control" id="priorite" name="priorite">
                            <option value="faible" {{ $tache->priorite === 'faible' ? 'selected' : '' }}>Faible</option>
                            <option value="moyenne" {{ $tache->priorite === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="forte" {{ $tache->priorite === 'forte' ? 'selected' : '' }}>Forte</option>
                        </select>
                    </div>
            
                    
                    <div class="form-group">
                        <label for="etat">Affecté à </label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">Non affecté</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $tache->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endforeach


<!-- Modal de modificationFinal -->
@php
$allUsers = App\Models\User::all();


$users = $allUsers->where('status', 1)
     ->whereNotNull('email_verified_at');

   
@endphp

@foreach($toutesLesTaches as $tache)
<div class="modal fade" id="modifyModalF{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifyModalLabel">Modifier la tâche</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulaire de modification -->
                <form action="{{ route('modifierTacheF', $tache->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" value="{{ $tache->titre }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $tache->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="dateDue">Date d'échéance</label>
                        <input type="date" class="form-control" id="dateDue" name="dateDue" value="{{ $tache->dateDue }}" required>
                    </div>

                    <div class="form-group">
                       
                        <input type="hidden" class="form-control" id="DateFin" name="DateFin" value="{{ $tache->DateFin }}" required>
                    </div>
               
                    
                    <div class="form-group">
                        <label for="priorite">Priorité</label>
                        <select class="form-control" id="priorite" name="priorite">
                            <option value="faible" {{ $tache->priorite === 'faible' ? 'selected' : '' }}>Faible</option>
                            <option value="moyenne" {{ $tache->priorite === 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="forte" {{ $tache->priorite === 'forte' ? 'selected' : '' }}>Forte</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="messageFin">message de Fin</label>
                        <textarea class="form-control" id="messageFin" name="messageFin"  required>{{ $tache->messageFin }}</textarea>
                    </div>
                    
                  

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endforeach



<!-- Modal de suppression -->
@foreach($toutesLesTaches as $tache)
<div class="modal fade" id="confirmDeleteModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette tâche ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <form action="{{ route('supprimerTache', $tache->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach


@foreach($toutesLesTaches as $tache)
<div class="modal fade" id="AffecterModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="AffecterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AffecterModalLabel">Affecter la tâche "{{ $tache->titre }}"</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                    // Récupérer l'utilisateur qui a créé la tâche en utilisant l'ID stocké dans createdBy
                    $createurId = $tache->createdBy;
                    $createur = App\Models\User::findOrFail($createurId);
                    $createurName = $createur->name;
                  
                  
                ?>
                <p><strong><span style="color: blue; font-weight: bold;">Créé par :</span></strong> {{ $createurName }}</p>
                <p><strong><span style="color: blue; font-weight: bold;">Date et heure de création :</span></strong> {{$tache->dateCreation  }}</p>
                <p><strong><span style="color: blue; font-weight: bold;">Date d'échéance :</span></strong> {{ $tache->dateDue }}   
                    @if(\Carbon\Carbon::parse($tache->dateDue)->isPast())
                        <span style="color: red;">(En retard de {{ \Carbon\Carbon::parse($tache->dateDue)->diffInDays() }} jours)</span>
                    @else
                        <span>(Il vous reste {{ \Carbon\Carbon::now()->diffInDays($tache->dateDue) }} jours)</span>
                    @endif
                </p>
              

                <p><strong><span style="color: blue; font-weight: bold;">Titre :</span></strong> {{ $tache->titre }}</p>
                <p><strong><span style="color: blue; font-weight: bold;">Description :</span></strong> {{ $tache->description }}</p>
                <p><strong><span style="color: blue; font-weight: bold;">Priorité :</span></strong> {{ $tache->priorite }}</p>
                <p><strong><span style="color: blue; font-weight: bold;">Etat :</span></strong> en attente de traitement </p>

                <form action="{{ route('affecterTacheModal', $tache->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">Affecter à </label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">Choisissez un utilisateur</option>
                            @foreach($users as $user)
                                @php
                                    $nbrTachesEnCours = $toutesLesTaches->where('user_id', $user->id)->where('etat', 'en cours')->count();
                                @endphp
                                <option value="{{ $user->id }}" {{ $tache->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $nbrTachesEnCours }} tâches en cours)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Affecter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach



@foreach($tachesEnCours as $tache)
    <!-- Modal pour le formulaire de marquage comme terminée -->
    <div class="modal fade" id="marquerTerminéeModal{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="marquerTerminéeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="marquerTerminéeModalLabel">Marquer la tâche comme terminée</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('marquerTerminée', ['id' => $tache->id]) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message">Message de fin :</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Marquer comme terminée</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach


@endsection
