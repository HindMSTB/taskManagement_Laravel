<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>RuangAdmin - Dashboard</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
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
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="adminDashboard.blade.php">
        <div class="sidebar-brand-icon">
          <img src="img/logo/logoRAD.png">
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('adminDashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
   
      <hr class="sidebar-divider">
      <div class="sidebar-heading">Gestion</div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Gestion des taches </span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Détails</h6>
            <a class="collapse-item" href="{{route('creerTacheFormA')}}">Créer une tache</a>
            <a class="collapse-item" href="{{route('listeToutesTacheA')}}">Lister toutes les taches</a>
            <a class="collapse-item" href="{{route('listetacheSupprimées')}}">Les taches supprimées</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fab fa-fw fa-wpforms"></i>
          <span>Gestion des comptes</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Détails</h6>
            <a class="collapse-item" href="{{route('creerCompteForm')}}">Ajouter un compte</a>
            <a class="collapse-item" href="{{ route('listeCompte') }}">Les comptes actifs</a>
            <a class="collapse-item" href="{{ route('comptesInactifs') }}">Les comptes non validés</a>
            <a class="collapse-item" href="{{route('compteSupprimés') }}">Les comptes supprimés</a>
          </div>
        </div>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">Mon espace</div>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('showProfileA') }}">
          <i class="fas fa-fw fa-user"></i>
          <span>Profil</span>
        </a>
      </li>
      <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                      this.closest('form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Déconnexion</span>
          </a>
        </form>
      </li>
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-1 small" placeholder="Que voulez-vous chercher ?"
                      aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
        <!-- Notification section -->
        <!-- Notification section -->
     <!-- Notification section -->
@php
    $notifications = App\Models\Notification::where('type', 'ajout')
        ->where('vu', 0)
        ->orderBy('date', 'desc')
        ->get();
    $unreadNotificationsCount = $notifications->count();
@endphp

<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw" id="markAllAsReadButton"></i>
        <span class="badge badge-danger badge-counter" id="notificationCount">{{ $unreadNotificationsCount }}</span>
    </a>
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
         aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">Notifications</h6>
        <ul id="notification-list" class="list-group">
            @foreach ($notifications as $notification)
            <li class="list-group-item d-flex align-items-center notification-item"
                id="notification-{{ $notification->id }}">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-file-alt text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ $notification->date }}</div>
                    <span class="font-weight-bold">{{ $notification->contenu }}</span>
                </div>
                <form method="POST" action="{{ route('markNotificationAsRead', ['id' => $notification->id]) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm ml-3">
                        <i class="fas fa-check-circle ml-auto text-success"></i>
                    </button>
                </form>
            </li>
            @endforeach
            @if ($notifications->isEmpty())
            <li class="list-group-item text-center small text-gray-500">Aucune notification</li>
            @endif
        </ul>
    </div>
</li>



<!-- End of notification section -->

            <x-app-layout></x-app-layout>
          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Container Fluid-->
    
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Taches </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                          @php
                           $user = Auth::user();
                           $tachesEnCoursCount = App\Models\Tache::where('status', 1)                 
                                                ->where('etat', 'en cours')
                                                ->whereNotNull('user_id')
                                                ->count();
                                  echo $tachesEnCoursCount;
                              @endphp
                    </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span class="text-danger mr-2">Les taches en cours</span>
                        <span></span>
                      </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span ></i> voir la liste</span>
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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Taches </div>
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
                        <span ></i> voir la liste</span>
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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Inscriptions</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
    @php
        
        $usersCount = App\Models\User::where('status','1')
        ->where('createdBy','inscription')
                          ->count();
     echo $usersCount;
    @endphp
</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                         <span class="text-success mr-2"> Comptes inscrit </span> 
                      
                      </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span ></i> voir la liste</span>
                    </div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-user-plus fa-2x text-success"></i>


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
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Utilisateurs</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">    @php
                       
                            $users = App\Models\User
                            ::where('status','1')
                         
                          ->count();
                           echo $users;
                         @endphp</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      <span class="text-success mr-2"> Nombre des utilisateurs  </span> 
                      
                       
                      </div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                        <span ></i> voir la liste</span>
                    </div>
                    </div>

                    <div class="col-auto">
                    <i class="fas fa-users fa-2x text-info"></i>
                    </div>

                    
                  </div>
                </div>
              </div>
            </div>

          
<!-- Pie Chart -->
<!-- Pie Chart -->
<!-- Pie Chart -->
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
               
                $users = App\Models\User::where('status', 1)
                                        ->whereNotNull('email_verified_at')
                                        ->get();
              @endphp

              @foreach ($users as $user)
                @php
                
                  $tachesTerminees = App\Models\Tache::where('user_id', $user->id)
                                                     ->where('status', 1)
                                                     ->where('etat', 'terminée')
                                                     ->count();
                  
                 
                  $totalTachesAffectees = App\Models\Tache::where('user_id', $user->id)
                                                          ->where('status', 1)
                                                          ->count();
                  
                 
                  if ($totalTachesAffectees > 0) {
                    $percentage = ($tachesTerminees / $totalTachesAffectees) * 100;
                  } else {
                    $percentage = 0;
                  }
                  
                 
                  $progressWidth = number_format($percentage, 2);
                  
                 
                  $progressClass = 'progress-width-' . floor($percentage / 10) * 10;

                 
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

  

    renderTable();
    updatePaginationButtons();
  });
</script>




            <!-- Invoice Example -->
          

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  



  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
  
 
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const notificationCountElement = document.getElementById('notificationCount');

    document.getElementById('markAllAsReadButton').addEventListener('click', function() {
        fetch('{{ route("markAllNotificationsAsRead") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                notificationCountElement.textContent = '0';
                document.querySelectorAll('.notification-item').forEach(function(item) {
                    item.classList.add('read'); // Ajoutez une classe pour marquer visuellement les notifications comme lues
                });
            } else {
                console.error('Failed to mark notifications as read');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

</script>


</body>

</html>