<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">

    <link rel="stylesheet" href="{{asset('assets/vendors/jvectormap/jquery-jvectormap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/owl-carousel-2/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/owl-carousel-2/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    @php
        $setting = App\Models\Setting::with('user')->first();
        $logo = $setting->image ?? '';
        $companyName = $setting->company_name ?? '';
        $admin_name = $setting->user->name ?? '';
        $pendingReservationsCount = \App\Models\Reservation::whereHas('reservationStatus', function($query) {
            $query->where('status', 'pending');
        })->count();
    @endphp
    <link rel="shortcut icon" href="{{asset($logo)}}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $('.loaderFullScreen').addClass('loader-active');
                },
                complete: function () {
                    $('.loaderFullScreen').removeClass('loader-active');
                }
            });
        });
    </script>
    @yield('css')
</head>
<body>
<div class="container-scroller">
    <!-- Sidebar-->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
            <a class="sidebar-brand brand-logo text-white" href="{{route('index')}}" style="text-decoration: none;text-wrap:nowrap;">{{\Illuminate\Support\Str::title($companyName)}}</a>
            <a class="sidebar-brand brand-logo-mini text-white" href="{{route('index')}}" style="text-decoration: none">{{\Illuminate\Support\Str::substr(\Illuminate\Support\Str::title($companyName),0,1)}}</a>
        </div>
        <ul class="nav">
            <li class="nav-item profile">
                <div class="profile-desc">
                    <div class="profile-pic">
                        <div class="count-indicator">
                            <span class="mdi mdi-account" style="font-size: 2rem"></span>
                        </div>
                        <div class="profile-name">
                            <h5 class="mb-0 font-weight-normal">{{\Illuminate\Support\Str::title($admin_name)}}</h5>
                            <span>Admin</span>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item nav-category">
                <span class="nav-link">Navigation</span>
            </li>
            <li class="nav-item menu-items {{Route::is('index') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('index')}}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
                    <span class="menu-title">Gösterge paneli</span>
                </a>
            </li>
            <li class="nav-item menu-items {{Route::is('reservations') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('reservations')}}">
              <span class="menu-icon">
                <i class="mdi mdi-account-check"></i>
              </span>
                    <span class="menu-title">Rezarvasyonlar</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link collapsed" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                 <span class="menu-icon">
                <i class="mdi mdi-shape-outline"></i>
              </span>
                    <span class="menu-title">Kategoriler</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic" style="">
                    <ul class="nav flex-column sub-menu">
                        @foreach(\App\Models\Category::orderBy('created_at', 'desc')->get() as $category)
                            <li class="nav-item"> <a class="nav-link" href="{{route('foods',['id' => $category->id])}}">{{ucfirst($category->name)}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="nav-item menu-items {{Route::is('users') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('users')}}">
              <span class="menu-icon">
                <i class="mdi  mdi-account"></i>
              </span>
                    <span class="menu-title">Kullanıcılar</span>
                </a>
            </li>
            <li class="nav-item menu-items {{Route::is('messages') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('messages')}}">
              <span class="menu-icon">
                <i class="mdi mdi-message-text-outline"></i>
              </span>
                    <span class="menu-title">Mesajlar</span>
                </a>
            </li>
            <li class="nav-item menu-items {{Route::is('settings') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('settings')}}">
              <span class="menu-icon">
                <i class="mdi mdi-settings"></i>
              </span>
                    <span class="menu-title">Ayarlar</span>
                </a>
            </li>
            <li class="nav-item menu-items">
                <a class="nav-link" href="{{route('logout')}}">
              <span class="menu-icon">
                <i class="mdi mdi-logout"></i>
              </span>
                    <span class="menu-title">Çıkış</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- Sidebar End-->
    <div class="container-fluid page-body-wrapper">
        <!-- Header-->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                @php($notReadMessageCount = \App\Models\Message::where('read_at',0)->whereHas('user', function($query) {
            $query->where('user_name', '!=', 'admin');
        })->count())
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle mx-0" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-bell"></i>
                            @if($notReadMessageCount +$pendingReservationsCount > 0)
                                <span class="count bg-danger"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                            <h6 class="p-3 mb-0">Bildirimler</h6>
                            {{--<div class="dropdown-divider"></div>
                            <a href="{{route('reservations')}}" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-account-check text-secondary"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1">Yeni rezervasyon var</p>
                                    <p class="text-muted ellipsis mb-0"> 2 </p>
                                </div>
                            </a>--}}
                            @if($notReadMessageCount)
                                <div class="dropdown-divider"></div>
                                <a href="{{route('messages')}}" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-email text-secondary"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Okunmamış mesaj var</p>
                                        <p class="text-muted ellipsis mb-0"> {{ $notReadMessageCount }} </p>
                                    </div>
                                </a>
                            @endif
                            @if($pendingReservationsCount)
                                <div class="dropdown-divider"></div>
                                <a href="{{route('reservations')}}" class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-account-check"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1" style="line-height: 1.2rem">İşlem yapılmamış<br> rezervasyon var</p>
                                        <p class="text-muted ellipsis mb-0"> {{ $pendingReservationsCount }} </p>
                                    </div>
                                </a>
                            @endif


                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                            <div class="navbar-profile">
                                <p class="mb-0 d-none d-sm-block navbar-profile-name">{{\Illuminate\Support\Str::title($admin_name)}}</p>
                                <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                            <h6 class="p-3 mb-0">Profil</h6>
                            <div class="dropdown-divider"></div>
                            <a href="{{route('settings')}}" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-settings text-success"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1">Ayarlar</p>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{route('logout')}}" class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-dark rounded-circle">
                                        <i class="mdi mdi-logout text-danger"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <p class="preview-subject mb-1">Çıkış</p>
                                </div>
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-format-line-spacing"></span>
                </button>
            </div>
        </nav>
        <!-- Header End -->
        @yield('content')

    </div>

</div>


<script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>

<script src="{{asset('assets/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
<script src="{{asset('assets/vendors/jvectormap/jquery-jvectormap.min.js')}}"></script>
<script src="{{asset('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('assets/vendors/owl-carousel-2/owl.carousel.min.js')}}"></script>

<script src="{{asset('assets/js/off-canvas.js')}}"></script>
<script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('assets/js/misc.js')}}"></script>
<script src="{{asset('assets/js/settings.js')}}"></script>
<script src="{{asset('assets/js/todolist.js')}}"></script>

<script src="{{asset('assets/js/dashboard.js')}}"></script>

<script>

    let btns = document.querySelectorAll(".btn-modal");
    let spans = document.querySelectorAll(".modal-close");

    btns.forEach(btn => {
        btn.onclick = function(e) {
            const btnId = e.target.id
            const modal = document.querySelector(`[data-id='${btnId}']`)
            modal.style.display = "flex";
        }
    })


    spans.forEach(span => {
        span.onclick = function(e) {
            e.target.closest('.modal').style.display = "none";
        }
    })

    window.onclick = function(event) {
        const modal = event.target.closest('#myModal')
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@yield('js')

</body>
</html>
