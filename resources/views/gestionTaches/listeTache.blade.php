@extends('layouts.app2')
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
                    <h6 class="m-0 font-weight-bold text-primary">Liste des tâches </h6>
                </div>
                <div class="card-body">
                    <!-- Tabs nav -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="taches-en-cours-tab" data-toggle="tab" href="#taches-en-cours" role="tab" aria-controls="taches-en-cours" aria-selected="true">Tâches en cours</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="taches-terminees-tab" data-toggle="tab" href="#taches-terminees" role="tab" aria-controls="taches-terminees" aria-selected="false">Tâches terminées</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Onglet pour les tâches en cours -->
                        <div class="tab-pane fade show active" id="taches-en-cours" role="tabpanel" aria-labelledby="taches-en-cours-tab">
                            <!-- Contenu des tâches en cours -->
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTableEnCours" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Description</th>
                                            <th>Date d'échéance</th>
                                            <th>Priorité</th>
                                            <th>Actions</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Boucle pour afficher les tâches en cours -->
                                        @foreach($tachesEnCours as $tache)
                                        <tr>
                                            <td>{{ $tache->titre }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($tache->description, 100) }} <!-- Limite la description à 100 caractères -->
   
        @if(strlen($tache->description) > 100) <!-- Affiche le lien "more" uniquement si la description est plus longue que 100 caractères -->
        <a href="#" class="more-link text-primary" data-toggle="modal"  data-target="#detailsModal{{ $tache->id }}">voir plus</a>
           
        @endif
    </td>
                                            <td @if(\Carbon\Carbon::parse($tache->dateDue)->isPast()) style="color: red;" @endif>{{ $tache->dateDue }}</td>
                                            <td>{{ $tache->priorite }}</td>
                                            <td>
                                                <!-- Actions pour chaque tâche -->
                                                <div class="dropdown" >
                                                    <button class="btn btn-secondary dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h fa-xs"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#marquerTerminéeModal{{ $tache->id }}">Marquer comme terminée</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailsModal{{ $tache->id }}">Détails</a>
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
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Description</th>
                                            <th>Date d'échéance</th>
                                            <th>Priorité</th>
                                            <th>Actions</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Boucle pour afficher les tâches terminées -->
                                        @foreach($tachesTerminees as $tache)
                                        <tr>
                                            <td>{{ $tache->titre }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($tache->description, 100) }} <!-- Limite la description à 100 caractères -->
   
   @if(strlen($tache->description) > 100) <!-- Affiche le lien "more" uniquement si la description est plus longue que 100 caractères -->
   <a href="#" class="more-link text-primary" data-toggle="modal"  data-target="#detailsModalTer{{ $tache->id }}">voir plus</a>
      
   @endif
</td>
                                            <td>{{ $tache->dateDue }}</td>
                                            <td>{{ $tache->priorite }}</td>
                                            <td>
                                                <!-- Actions pour chaque tâche -->
                                                <div class="dropdown" >
                                                    <button class="btn btn-secondary dropdown-toggle p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-h fa-xs"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    
                                                      
                                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#detailsModalTer{{ $tache->id }}">Details</a>

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
    <!-- Modal pour afficher les détails de la tâche terminée -->
    <div class="modal fade" id="detailsModalTer{{ $tache->id }}" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel"><span style="color:black;font-weight: bold;">Détails de la tâche terminée : </span> {{ $tache->titre }}</h5>
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
                    <p><strong><span style="color: blue; font-weight: bold;">Date et heure de création :</span></strong> {{ $tache->dateCreation }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Date d'échéance :</span></strong> {{ $tache->dateDue }}    </p>
                    <p><strong><span style="color: blue; font-weight: bold;">Marquée comme Terminée Le :</span></strong> {{ $tache->DateFin }}
                    @if(\Carbon\Carbon::parse($tache->dateDue)->isPast())
                        <span style="color: red;">(En retard de {{ \Carbon\Carbon::parse($tache->dateDue)->diffInDays() }} jours)</span>
                    @else
                        <span>(Terminée {{ \Carbon\Carbon::parse($tache->dateDue)->diffInDays($tache->updated_at) }} jours avant la date d'échéance)</span>
                    @endif
                    </p>
                    <p><strong><span style="color: blue; font-weight: bold;">Message:</span></strong> {{ $tache->messageFin }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Titre :</span></strong> {{ $tache->titre }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Description :</strong></span> {{ $tache->description }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">Priorité :</strong></span> {{ $tache->priorite }}</p>
                    <p><strong><span style="color: blue; font-weight: bold;">État :</strong> </span>{{ $tache->etat }}</p>
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
                    <!-- Vérifier s'il y a des modifications pour cette tâche -->
                    <?php
                    $modifications = App\Models\Tache::where('tacheOrig', $tache->tacheOrig)->whereNotNull('dateModification')->get();
                    ?>
                    @if($modifications->isEmpty())
                        <p><strong>Création :</strong> {{ $tache->dateCreation }} par {{ $createurName }}</p>
                        <p><strong>Terminée :</strong> {{ $tache->DateFin }} </p>
                        <p>Aucune modification n'a encore été apportée à cette tâche.</p>
                    @else
                        <!-- Afficher les détails de création -->
                        <p><strong>Création :</strong> {{ $tache->dateCreation }} par {{ $createurName }}</p>
                        <!-- Afficher les modifications -->
                        <p><strong>Terminée :</strong> {{ $tache->DateFin }} </p>
                        <strong>Modification :</strong>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date et heure de modification</th>
                                    <th>Modifié par</th>
                                    <th>Détails</th>
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
                    <!-- Vérifier s'il y a des modifications pour cette tâche -->
                    <?php
                    $modifications = App\Models\Tache::where('tacheOrig', $tache->tacheOrig)->whereNotNull('dateModification')->get();
                    ?>
                    @if($modifications->isEmpty())
                        <p><strong>Création :</strong> {{ $tache->dateCreation }} par {{ $createurName }}</p>
                        <p>Aucune modification n'a encore été apportée à cette tâche.</p>
                    @else
                        <!-- Afficher les détails de création -->
                        <p><strong>Création :</strong> {{ $tache->dateCreation }} par {{ $createurName }}</p>
                        <!-- Afficher les modifications -->
                        <strong>Modification :</strong>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date et heure de modification</th>
                                    <th>Modifié par</th>
                                    <th>Détails</th>
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













<!-- Affichage du message de succès -->
@endsection

