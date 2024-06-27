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

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/ruang-admin.css') }}">
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">

    <style>
    .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            background-color: #3f51b5; /* Couleur de fond du sidebar */
            z-index: 1030;
        }

        /* Content wrapper */
        #content-wrapper {
            margin-left: 240px; /* Same as sidebar width */
            position: relative;
            padding-top: 60px; /* Same as topbar height */
        }

        /* TopBar */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 225px; /* Same as sidebar width */
            z-index: 1030;
           /* Couleur de fond du topbar */
            height: 70px; /* Hauteur de la barre supérieure */
        }

    </style>
</head>

<body id="page-top">
    <div id="wrapper">
         <!-- Sidebar -->
         <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('admin/img/logo/logo2.png') }}">
                </div>
                <div class="sidebar-brand-text mx-3">TEST</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Gestion
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="far fa-fw fa-window-maximize"></i>
                    <span>Gestion des taches </span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Détails</h6>
                        <a class="collapse-item" href="{{ route('ajouterTacheForm') }}">Commencer une tâche</a>
                        <a class="collapse-item" href="{{ route('listeTache') }}">Lister mes tâches</a>
                 
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                mon espace
            </div>  
            <li class="nav-item">
        <a class="nav-link"  href="{{ route('showProfile') }}" >
          <i class="fas fa-fw fa-chart-area"></i>
          <span > Profile </span>
        </a>
      </li>
        </ul>
        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('admin/img/logo/logo2.png') }}">
                </div>
                <div class="sidebar-brand-text mx-3">TEST</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Gestion
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                    aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="far fa-fw fa-window-maximize"></i>
                    <span>Gestion des tickets  </span>
                </a>
                <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Détails</h6>
                        <a class="collapse-item" href="{{ route('ajouterTacheForm') }}"> créer une ticket </a>
                        <a class="collapse-item" href="{{ route('listeTacheDemmandée') }}">Lister mes tickets </a>
                    </div>

                   
                </div> 

              
            </li>

            

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Taches
            </div>  

 <li class="nav-item">
    <a class="nav-link" href="{{ route('listeTache') }}">
        <i class="fas fa-fw fa-user"></i>
        <span>Lister mes taches</span>
    </a>
</li>     
        
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                mon espace
            </div>  

    <li class="nav-item">
    <a class="nav-link" href="{{ route('showProfile') }}">
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
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-1 small"
                                            placeholder="What do you want to look for?" aria-label="Search"
                                            aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <x-app-layout>
        </x-app-layout>
                    </ul>
                </nav>
                <!-- TopBar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                   
                        <div>
                            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                           
                                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                    @livewire('profile.update-profile-information-form')
                                    <x-section-border />
                                @endif

                                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                    <div class="mt-10 sm:mt-0">
                                        @livewire('profile.update-password-form')
                                    </div>
                                    <x-section-border />
                                @endif

                                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                                    <x-section-border />
                                    <div class="mt-10 sm:mt-0">
                                        @livewire('profile.delete-user-form')
                                    </div>
                                @endif
                            </div>
                        </div>
                   
                </div>
                <!--- Container Fluid-->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="{{ asset('admin/js/script.js') }}"></script>

    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('admin/js/ruang-admin.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>

</body>

</html>
