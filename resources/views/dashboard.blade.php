@extends('layouts.app2')

@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>

     <!-- Première ligne de cartes -->
<!-- Première ligne de cartes -->
<div class="row">
    <!-- Taches en cours -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Taches</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @php
                                $user = Auth::user();
                                $tachesEnCoursCount = App\Models\Tache::where('user_id', $user->id)
                                                                      ->where('status', 1)
                                                                      ->where('etat', 'en cours')
                                                                      ->count();
                                echo $tachesEnCoursCount;
                            @endphp
                        </div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-danger mr-2">Les taches en cours</span>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-tasks fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Taches terminées -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Taches</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">@php
                                $user = Auth::user();
                                $tachesEnCoursCount = App\Models\Tache::where('user_id', $user->id)
                                                                      ->where('status', 1)
                                                                      ->where('etat', 'terminée')
                                                                      ->count();
                                echo $tachesEnCoursCount;
                            @endphp      </div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-success">Les tâches terminées</span>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Taches en retard -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Taches</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          @php
                           $user = Auth::user();
                           $tachesEnCoursCount = App\Models\Tache::where('user_id', $user->id)
                                                ->where('status', 1)
                                                ->where('etat', 'en cours')
                                                ->whereDate('dateDue', '<', now())
                                                ->count();
                                  echo $tachesEnCoursCount;
                              @endphp
                    </div>

                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-danger mr-2">En retard</span>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mes tickets en cours de traitement -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Mes tickets</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          @php
                           $user = Auth::user();
                           $tachesEnCoursCount = App\Models\Tache::where('createdBy', $user->id)
                                                ->where('status', 1)
                                                ->where('etat', 'en cours')
                                                ->whereNotNull('user_id')
                                                 ->count();
                                  echo $tachesEnCoursCount;
                              @endphp
                    </div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-danger mr-2">En cours de traitement</span>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deuxième ligne de cartes -->
<div class="row justify-content-center">
    <!-- Mes tickets en attente d'affectation -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Mes tickets</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          @php
                           $user = Auth::user();
                           $tachesEnCoursCount = App\Models\Tache::where('createdBy', $user->id)
                                                ->where('status', 1)
                                                ->where('etat', 'en cours ')
                                                ->whereNull('user_id')
                                                 ->count();
                                  echo $tachesEnCoursCount;
                              @endphp
                    </div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-danger mr-2">En attente d'affectation</span>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-hourglass-half fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mes tickets terminés -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Mes tickets</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                          @php
                           $user = Auth::user();
                           $tachesEnCoursCount = App\Models\Tache::where('createdBy', $user->id)
                                                ->where('status', 1)
                                                ->where('etat', 'terminée')
                                            
                                                 ->count();
                                  echo $tachesEnCoursCount;
                              @endphp
                    </div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-success">Terminés</span>
                        </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-check-double fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!---Container Fluid-->
@endsection
