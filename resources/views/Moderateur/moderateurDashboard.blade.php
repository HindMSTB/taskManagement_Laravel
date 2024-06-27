@extends('layouts.app3')

@section('content')
<style>
 .progress-width-0 { width: 0%; }
.progress-width-10 { width: 10%; }
.progress-width-20 { width: 20%; }
.progress-width-30 { width: 30%; }
.progress-width-40 { width: 40%; }
.progress-width-50 { width: 50%; }
.progress-width-60 { width: 60%; }
.progress-width-70 { width: 70%; }
.progress-width-80 { width: 80%; }
.progress-width-90 { width: 90%; }
.progress-width-100 { width: 100%; }

</style>
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

        <!-- Row -->
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Taches </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                         
                         $tachesCount = App\Models\Tache::where('status', 1)                 
                                              ->where('etat', 'en cours')
                                              ->where('etat', 'en cours')
                                                ->whereNotNull('user_id')
                                              ->count();
                                echo $tachesCount;
                            @endphp
                            </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-danger mr-2">Les taches en cours</span>
                                
                                    <span></span>
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Taches</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                          @php
                           $user = Auth::user();
                           $tachesEnCoursCount = App\Models\Tache::where('status', 1)                 
                                                ->where('etat', 'terminée')
                                                ->whereNotNull('user_id')
                                                ->count();
                                  echo $tachesEnCoursCount;
                              @endphp
                    </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success"> Les tâches terminées</span>
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Taches</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                         
                         $tachesCount = App\Models\Tache::where('status', 1)                 
                                              ->where('etat', 'en cours')
                                              ->where('priorite', 'forte')  
                                              ->count();
                                echo $tachesCount;
                            @endphp
                            </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-danger mr-2"> les taches urgentes  </span>
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span></span>
                                </div>
                            </div>
                            <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">taches </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                           $user = Auth::user();
                           $tachesEnCoursCount = App\Models\Tache::where('status', 1)                 
                                                ->where('etat', 'en cours')
                                                ->whereDate('dateDue', '<', now())
                                                ->count();
                                  echo $tachesEnCoursCount;
                              @endphp
                              
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-danger mr-2"> en retard  </span>
                                </div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span></span>
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
        <!--Row-->
    </div>
    <!-- Pie Chart -->
<div class="row" style="width: 25cm; padding-left: 10px;">
  <div class="col-lg-12 mb-4">
    <div class="card">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Utilisateurs et leurs tâches terminées</h6>
        <div>
          <label for="rowsPerPage" class="mr-2">Nombre de lignes :</label>
          <select id="rowsPerPage" class="form-control d-inline-block w-auto">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table align-items-center table-flush" id="userTable">
            <thead class="thead-light">
              <tr>
                <th>Nom de l'utilisateur</th>
                <th>Tâches terminées</th>
                <th>Pourcentage</th>
                <th>En retard</th>
              </tr>
            </thead>
            <tbody>
              @php
                // Récupérer tous les utilisateurs actifs avec leurs tâches terminées
                $users = App\Models\User::where('status', 1)
                                        ->whereNotNull('email_verified_at')
                                        ->get();
              @endphp

              @foreach ($users as $user)
                @php
                  // Compter le nombre de tâches terminées de l'utilisateur
                  $tachesTerminees = App\Models\Tache::where('user_id', $user->id)
                                                     ->where('status', 1)
                                                     ->where('etat', 'terminée')
                                                     ->count();
                  
                  // Total des tâches affectées à l'utilisateur (par exemple, toutes les tâches avec statut = 1)
                  $totalTachesAffectees = App\Models\Tache::where('user_id', $user->id)
                                                          ->where('status', 1)
                                                          ->count();
                  
                  // Calculer le pourcentage de tâches terminées
                  if ($totalTachesAffectees > 0) {
                    $percentage = ($tachesTerminees / $totalTachesAffectees) * 100;
                  } else {
                    $percentage = 0;
                  }
                  
                  // Formater le pourcentage à deux décimales
                  $progressWidth = number_format($percentage, 2);
                  
                  // Déterminer la classe de progression en fonction du pourcentage
                  $progressClass = 'progress-width-' . floor($percentage / 10) * 10;

                  // Classe de couleur
                  if ($percentage > 0 && $percentage <= 25) {
                    $progressColorClass = 'bg-danger';
                  } elseif ($percentage > 25 && $percentage <= 50) {
                    $progressColorClass = 'bg-warning';
                  } elseif ($percentage > 50 && $percentage <= 75) {
                    $progressColorClass = 'bg-info';
                  } elseif ($percentage > 75 && $percentage <= 100) {
                    $progressColorClass = 'bg-success';
                  } else {
                    $progressColorClass = 'bg-secondary';
                  }

                  // Vérifier les tâches terminées en retard
                  $tachesEnRetard = App\Models\Tache::where('user_id', $user->id)
                                                     ->where('status', 1)
                                                     ->where('etat', 'terminée')
                                                     ->where('dateDue', '<', now())
                                                     ->count();
                @endphp

                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $tachesTerminees }} de {{ $totalTachesAffectees }}</td>
                  <td>
                    <div class="progress" style="height: 12px;">
                      <div class="progress-bar {{ $progressColorClass }} {{ $progressClass }}" role="progressbar"
                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressWidth }}%
                      </div>
                    </div>
                  </td>
                  <td>
                    {{ $tachesEnRetard > 0 ? $tachesEnRetard : 0 }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="d-flex justify-content-between mt-3">
           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('userTable').getElementsByTagName('tbody')[0];
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
 

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value);
    let rows = Array.from(table.getElementsByTagName('tr'));

    function renderTable() {
      table.innerHTML = '';
      const start = (currentPage - 1) * rowsPerPage;
      const end = start + rowsPerPage;
      const paginatedRows = rows.slice(start, end);

      paginatedRows.forEach(row => {
        table.appendChild(row);
      });
    }

    function updatePaginationButtons() {
      prevPageButton.disabled = currentPage === 1;
      nextPageButton.disabled = currentPage * rowsPerPage >= rows.length;
    }

    rowsPerPageSelect.addEventListener('change', function() {
      rowsPerPage = parseInt(this.value);
      currentPage = 1;
      renderTable();
      updatePaginationButtons();
    });

  

    // Initial render
    renderTable();
    updatePaginationButtons();
  });
</script>



    <!---Container Fluid-->
@endsection
