<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ url('/') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="35">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::asset('assets/images/logo-dark.png') }}" alt="" height="30">
                        </span>
                    </a>

                    <a href="{{ url('/') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('assets/images/logo-sm.png') }}" alt="" height="35">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::asset('assets/images/logo-light.png') }}" alt="" height="30">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                {{--              <form class="app-search d-none d-md-block"> --}}
                {{--                    <div class="position-relative"> --}}
                {{--                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off" --}}
                {{--                            id="search-options" value=""> --}}
                {{--                        <span class="mdi mdi-magnify search-widget-icon"></span> --}}
                {{--                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" --}}
                {{--                            id="search-close-options"></span> --}}
                {{--                    </div> --}}
                {{--                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown"> --}}
                {{--                        <div data-simplebar style="max-height: 320px;"> --}}
                {{--                            <!-- item--> --}}
                {{--                            <div class="dropdown-header"> --}}
                {{--                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6> --}}
                {{--                            </div> --}}

                {{--                            <div class="dropdown-item bg-transparent text-wrap"> --}}
                {{--                                <a href="index" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i --}}
                {{--                                        class="mdi mdi-magnify ms-1"></i></a> --}}
                {{--                                <a href="index" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i --}}
                {{--                                        class="mdi mdi-magnify ms-1"></i></a> --}}
                {{--                            </div> --}}
                {{--                            <!-- item--> --}}
                {{--                            <div class="dropdown-header mt-2"> --}}
                {{--                                <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6> --}}
                {{--                            </div> --}}

                {{--                            <!-- item--> --}}
                {{--                            <a href="javascript:void(0);" class="dropdown-item notify-item"> --}}
                {{--                                <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i> --}}
                {{--                                <span>Analytics Dashboard</span> --}}
                {{--                            </a> --}}

                {{--                            <!-- item--> --}}
                {{--                            <a href="javascript:void(0);" class="dropdown-item notify-item"> --}}
                {{--                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i> --}}
                {{--                                <span>Help Center</span> --}}
                {{--                            </a> --}}

                {{--                            <!-- item--> --}}
                {{--                            <a href="javascript:void(0);" class="dropdown-item notify-item"> --}}
                {{--                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i> --}}
                {{--                                <span>My account settings</span> --}}
                {{--                            </a> --}}

                {{--                            <!-- item--> --}}
                {{--                            <div class="dropdown-header mt-2"> --}}
                {{--                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6> --}}
                {{--                            </div> --}}

                {{--                            <div class="notification-list"> --}}
                {{--                                <!-- item --> --}}
                {{--                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2"> --}}
                {{--                                    <div class="d-flex"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" --}}
                {{--                                            class="me-3 rounded-circle avatar-xs" alt="user-pic"> --}}
                {{--                                        <div class="flex-1"> --}}
                {{--                                            <h6 class="m-0">Angela Bernier</h6> --}}
                {{--                                            <span class="fs-11 mb-0 text-muted">Manager</span> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </a> --}}
                {{--                                <!-- item --> --}}
                {{--                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2"> --}}
                {{--                                    <div class="d-flex"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" --}}
                {{--                                            class="me-3 rounded-circle avatar-xs" alt="user-pic"> --}}
                {{--                                        <div class="flex-1"> --}}
                {{--                                            <h6 class="m-0">David Grasso</h6> --}}
                {{--                                            <span class="fs-11 mb-0 text-muted">Web Designer</span> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </a> --}}
                {{--                                <!-- item --> --}}
                {{--                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2"> --}}
                {{--                                    <div class="d-flex"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/users/avatar-5.jpg') }}" --}}
                {{--                                            class="me-3 rounded-circle avatar-xs" alt="user-pic"> --}}
                {{--                                        <div class="flex-1"> --}}
                {{--                                            <h6 class="m-0">Mike Bunch</h6> --}}
                {{--                                            <span class="fs-11 mb-0 text-muted">React Developer</span> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </a> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}

                {{--                        <div class="text-center pt-3 pb-1"> --}}
                {{--                            <a href="pages-search-results" class="btn btn-primary btn-sm">View All Results <i --}}
                {{--                                    class="ri-arrow-right-line ms-1"></i></a> --}}
                {{--                        </div> --}}
                {{--                    </div> --}}
                {{--                </form> --}}
            </div>

            <div class="d-flex align-items-center">

                {{--                <div class="dropdown d-md-none topbar-head-dropdown header-item"> --}}
                {{--                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" --}}
                {{--                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" --}}
                {{--                        aria-expanded="false"> --}}
                {{--                        <i class="bx bx-search fs-22"></i> --}}
                {{--                    </button> --}}
                {{--                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" --}}
                {{--                        aria-labelledby="page-header-search-dropdown"> --}}
                {{--                        <form class="p-3"> --}}
                {{--                            <div class="form-group m-0"> --}}
                {{--                                <div class="input-group"> --}}
                {{--                                    <input type="text" class="form-control" placeholder="Search ..." --}}
                {{--                                        aria-label="Recipient's username"> --}}
                {{--                                    <button class="btn btn-primary" type="submit"><i --}}
                {{--                                            class="mdi mdi-magnify"></i></button> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </form> --}}
                {{--                    </div> --}}
                {{--                </div> --}}

                {{--                <div class="dropdown ms-1 topbar-head-dropdown header-item"> --}}
                {{--                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" --}}
                {{--                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> --}}
                {{--                        @switch(Session::get('lang')) --}}
                {{--                        @case('ru') --}}
                {{--                            <img src="{{ URL::asset('/assets/images/flags/russia.svg') }}" class="rounded" alt="Header Language" --}}
                {{--                                height="20"> --}}
                {{--                        @break --}}
                {{--                        @case('it') --}}
                {{--                            <img src="{{ URL::asset('/assets/images/flags/italy.svg') }}" class="rounded" alt="Header Language" --}}
                {{--                                height="20"> --}}
                {{--                        @break --}}
                {{--                        @case('sp') --}}
                {{--                            <img src="{{ URL::asset('/assets/images/flags/spain.svg') }}" class="rounded" alt="Header Language" --}}
                {{--                                height="20"> --}}
                {{--                        @break --}}
                {{--                        @case('ch') --}}
                {{--                            <img src="{{ URL::asset('/assets/images/flags/china.svg') }}" class="rounded" alt="Header Language" --}}
                {{--                                height="20"> --}}
                {{--                        @break --}}
                {{--                        @case('fr') --}}
                {{--                            <img src="{{ URL::asset('/assets/images/flags/french.svg') }}" class="rounded" alt="Header Language" --}}
                {{--                                height="20"> --}}
                {{--                        @break --}}
                {{--                        @case('gr') --}}
                {{--                            <img src="{{ URL::asset('/assets/images/flags/germany.svg') }}" class="rounded" alt="Header Language" --}}
                {{--                                height="20"> --}}
                {{--                        @break --}}
                {{--                        @default --}}
                {{--                            <img src="{{ URL::asset('/assets/images/flags/us.svg') }}" class="rounded" alt="Header Language" height="20"> --}}
                {{--                    @endswitch --}}
                {{--                    </button> --}}
                {{--                    <div class="dropdown-menu dropdown-menu-end"> --}}

                {{--                        <!-- item--> --}}
                {{--                        <a href="{{ url('index/en') }}" class="dropdown-item notify-item language py-2" data-lang="en" --}}
                {{--                            title="English"> --}}
                {{--                            <img src="{{ URL::asset('assets/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="20"> --}}
                {{--                            <span class="align-middle">English</span> --}}
                {{--                        </a> --}}

                {{--                        <!-- item--> --}}
                {{--                        <a href="{{ url('index/sp') }}" class="dropdown-item notify-item language" data-lang="sp" --}}
                {{--                            title="Spanish"> --}}
                {{--                            <img src="{{ URL::asset('assets/images/flags/spain.svg') }}" alt="user-image" class="me-2 rounded" height="20"> --}}
                {{--                            <span class="align-middle">Espa??ola</span> --}}
                {{--                        </a> --}}

                {{--                        <!-- item--> --}}
                {{--                        <a href="{{ url('index/gr') }}" class="dropdown-item notify-item language" data-lang="gr" --}}
                {{--                            title="German"> --}}
                {{--                            <img src="{{ URL::asset('assets/images/flags/germany.svg') }}" alt="user-image" class="me-2 rounded" --}}
                {{--                                height="20"> <span class="align-middle">Deutsche</span> --}}
                {{--                        </a> --}}

                {{--                        <!-- item--> --}}
                {{--                        <a href="{{ url('index/it') }}" class="dropdown-item notify-item language" data-lang="it" --}}
                {{--                            title="Italian"> --}}
                {{--                            <img src="{{ URL::asset('assets/images/flags/italy.svg') }}" alt="user-image" class="me-2 rounded" height="20"> --}}
                {{--                            <span class="align-middle">Italiana</span> --}}
                {{--                        </a> --}}

                {{--                        <!-- item--> --}}
                {{--                        <a href="{{ url('index/ru') }}" class="dropdown-item notify-item language" data-lang="ru" --}}
                {{--                            title="Russian"> --}}
                {{--                            <img src="{{ URL::asset('assets/images/flags/russia.svg') }}" alt="user-image" class="me-2 rounded" height="20"> --}}
                {{--                            <span class="align-middle">??????????????</span> --}}
                {{--                        </a> --}}

                {{--                        <!-- item--> --}}
                {{--                        <a href="{{ url('index/ch') }}" class="dropdown-item notify-item language" data-lang="ch" --}}
                {{--                            title="Chinese"> --}}
                {{--                            <img src="{{ URL::asset('assets/images/flags/china.svg') }}" alt="user-image" class="me-2 rounded" height="20"> --}}
                {{--                            <span class="align-middle">?????????</span> --}}
                {{--                        </a> --}}

                {{--                        <!-- item--> --}}
                {{--                        <a href="{{ url('index/fr') }}" class="dropdown-item notify-item language" data-lang="fr" --}}
                {{--                            title="French"> --}}
                {{--                            <img src="{{ URL::asset('assets/images/flags/french.svg') }}" alt="user-image" class="me-2 rounded" height="20"> --}}
                {{--                            <span class="align-middle">fran??ais</span> --}}
                {{--                        </a> --}}
                {{--                    </div> --}}
                {{--                </div> --}}

                {{--                <div class="dropdown topbar-head-dropdown ms-1 header-item"> --}}
                {{--                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" --}}
                {{--                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> --}}
                {{--                        <i class='bx bx-category-alt fs-22'></i> --}}
                {{--                    </button> --}}
                {{--                    <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end"> --}}
                {{--                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border"> --}}
                {{--                            <div class="row align-items-center"> --}}
                {{--                                <div class="col"> --}}
                {{--                                    <h6 class="m-0 fw-semibold fs-15"> Web Apps </h6> --}}
                {{--                                </div> --}}
                {{--                                <div class="col-auto"> --}}
                {{--                                    <a href="#!" class="btn btn-sm btn-soft-info"> View All Apps --}}
                {{--                                        <i class="ri-arrow-right-s-line align-middle"></i></a> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}

                {{--                        <div class="p-2"> --}}
                {{--                            <div class="row g-0"> --}}
                {{--                                <div class="col"> --}}
                {{--                                    <a class="dropdown-icon-item" href="#!"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/brands/github.png') }}" alt="Github"> --}}
                {{--                                        <span>GitHub</span> --}}
                {{--                                    </a> --}}
                {{--                                </div> --}}
                {{--                                <div class="col"> --}}
                {{--                                    <a class="dropdown-icon-item" href="#!"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/brands/bitbucket.png') }}" alt="bitbucket"> --}}
                {{--                                        <span>Bitbucket</span> --}}
                {{--                                    </a> --}}
                {{--                                </div> --}}
                {{--                                <div class="col"> --}}
                {{--                                    <a class="dropdown-icon-item" href="#!"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/brands/dribbble.png') }}" alt="dribbble"> --}}
                {{--                                        <span>Dribbble</span> --}}
                {{--                                    </a> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}

                {{--                            <div class="row g-0"> --}}
                {{--                                <div class="col"> --}}
                {{--                                    <a class="dropdown-icon-item" href="#!"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/brands/dropbox.png') }}" alt="dropbox"> --}}
                {{--                                        <span>Dropbox</span> --}}
                {{--                                    </a> --}}
                {{--                                </div> --}}
                {{--                                <div class="col"> --}}
                {{--                                    <a class="dropdown-icon-item" href="#!"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/brands/mail_chimp.png') }}" alt="mail_chimp"> --}}
                {{--                                        <span>Mail Chimp</span> --}}
                {{--                                    </a> --}}
                {{--                                </div> --}}
                {{--                                <div class="col"> --}}
                {{--                                    <a class="dropdown-icon-item" href="#!"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/brands/slack.png') }}" alt="slack"> --}}
                {{--                                        <span>Slack</span> --}}
                {{--                                    </a> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                    </div> --}}
                {{--                </div> --}}

                {{--                <div class="dropdown topbar-head-dropdown ms-1 header-item"> --}}
                {{--                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" --}}
                {{--                        id="page-header-cart-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" --}}
                {{--                        aria-haspopup="true" aria-expanded="false"> --}}
                {{--                        <i class='bx bx-shopping-bag fs-22'></i> --}}
                {{--                        <span --}}
                {{--                            class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-info">5</span> --}}
                {{--                    </button> --}}
                {{--                    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart" --}}
                {{--                        aria-labelledby="page-header-cart-dropdown"> --}}
                {{--                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border"> --}}
                {{--                            <div class="row align-items-center"> --}}
                {{--                                <div class="col"> --}}
                {{--                                    <h6 class="m-0 fs-16 fw-semibold"> My Cart</h6> --}}
                {{--                                </div> --}}
                {{--                                <div class="col-auto"> --}}
                {{--                                    <span class="badge badge-soft-warning fs-13"><span class="cartitem-badge">7</span> --}}
                {{--                                        items</span> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                        <div data-simplebar style="max-height: 300px;"> --}}
                {{--                            <div class="p-2"> --}}
                {{--                                <div class="text-center empty-cart" id="empty-cart"> --}}
                {{--                                    <div class="avatar-md mx-auto my-3"> --}}
                {{--                                        <div class="avatar-title bg-soft-info text-info fs-36 rounded-circle"> --}}
                {{--                                            <i class='bx bx-cart'></i> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                    <h5 class="mb-3">Your Cart is Empty!</h5> --}}
                {{--                                    <a href="#" class="btn btn-success w-md mb-3">Shop Now</a> --}}
                {{--                                </div> --}}
                {{--                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2"> --}}
                {{--                                    <div class="d-flex align-items-center"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/products/img-1.png') }}" --}}
                {{--                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> --}}
                {{--                                        <div class="flex-1"> --}}
                {{--                                            <h6 class="mt-0 mb-1 fs-14"> --}}
                {{--                                                <a href="apps-ecommerce-product-details" class="text-reset">Branded --}}
                {{--                                                    T-Shirts</a> --}}
                {{--                                            </h6> --}}
                {{--                                            <p class="mb-0 fs-12 text-muted"> --}}
                {{--                                                Quantity: <span>10 x $32</span> --}}
                {{--                                            </p> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="px-2"> --}}
                {{--                                            <h5 class="m-0 fw-normal">$<span class="cart-item-price">320</span></h5> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="ps-2"> --}}
                {{--                                            <button type="button" --}}
                {{--                                                class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i --}}
                {{--                                                    class="ri-close-fill fs-16"></i></button> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </div> --}}

                {{--                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2"> --}}
                {{--                                    <div class="d-flex align-items-center"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/products/img-2.png') }}" --}}
                {{--                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> --}}
                {{--                                        <div class="flex-1"> --}}
                {{--                                            <h6 class="mt-0 mb-1 fs-14"> --}}
                {{--                                                <a href="apps-ecommerce-product-details" --}}
                {{--                                                    class="text-reset">Bentwood Chair</a> --}}
                {{--                                            </h6> --}}
                {{--                                            <p class="mb-0 fs-12 text-muted"> --}}
                {{--                                                Quantity: <span>5 x $18</span> --}}
                {{--                                            </p> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="px-2"> --}}
                {{--                                            <h5 class="m-0 fw-normal">$<span class="cart-item-price">89</span></h5> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="ps-2"> --}}
                {{--                                            <button type="button" --}}
                {{--                                                class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i --}}
                {{--                                                    class="ri-close-fill fs-16"></i></button> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </div> --}}

                {{--                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2"> --}}
                {{--                                    <div class="d-flex align-items-center"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/products/img-3.png') }}" --}}
                {{--                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> --}}
                {{--                                        <div class="flex-1"> --}}
                {{--                                            <h6 class="mt-0 mb-1 fs-14"> --}}
                {{--                                                <a href="apps-ecommerce-product-details" class="text-reset"> --}}
                {{--                                                    Borosil Paper Cup</a> --}}
                {{--                                            </h6> --}}
                {{--                                            <p class="mb-0 fs-12 text-muted"> --}}
                {{--                                                Quantity: <span>3 x $250</span> --}}
                {{--                                            </p> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="px-2"> --}}
                {{--                                            <h5 class="m-0 fw-normal">$<span class="cart-item-price">750</span></h5> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="ps-2"> --}}
                {{--                                            <button type="button" --}}
                {{--                                                class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i --}}
                {{--                                                    class="ri-close-fill fs-16"></i></button> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </div> --}}

                {{--                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2"> --}}
                {{--                                    <div class="d-flex align-items-center"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/products/img-6.png') }}" --}}
                {{--                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> --}}
                {{--                                        <div class="flex-1"> --}}
                {{--                                            <h6 class="mt-0 mb-1 fs-14"> --}}
                {{--                                                <a href="apps-ecommerce-product-details" class="text-reset">Gray --}}
                {{--                                                    Styled T-Shirt</a> --}}
                {{--                                            </h6> --}}
                {{--                                            <p class="mb-0 fs-12 text-muted"> --}}
                {{--                                                Quantity: <span>1 x $1250</span> --}}
                {{--                                            </p> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="px-2"> --}}
                {{--                                            <h5 class="m-0 fw-normal">$ <span class="cart-item-price">1250</span></h5> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="ps-2"> --}}
                {{--                                            <button type="button" --}}
                {{--                                                class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i --}}
                {{--                                                    class="ri-close-fill fs-16"></i></button> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </div> --}}

                {{--                                <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2"> --}}
                {{--                                    <div class="d-flex align-items-center"> --}}
                {{--                                        <img src="{{ URL::asset('assets/images/products/img-5.png') }}" --}}
                {{--                                            class="me-3 rounded-circle avatar-sm p-2 bg-light" alt="user-pic"> --}}
                {{--                                        <div class="flex-1"> --}}
                {{--                                            <h6 class="mt-0 mb-1 fs-14"> --}}
                {{--                                                <a href="apps-ecommerce-product-details" --}}
                {{--                                                    class="text-reset">Stillbird Helmet</a> --}}
                {{--                                            </h6> --}}
                {{--                                            <p class="mb-0 fs-12 text-muted"> --}}
                {{--                                                Quantity: <span>2 x $495</span> --}}
                {{--                                            </p> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="px-2"> --}}
                {{--                                            <h5 class="m-0 fw-normal">$<span class="cart-item-price">990</span></h5> --}}
                {{--                                        </div> --}}
                {{--                                        <div class="ps-2"> --}}
                {{--                                            <button type="button" --}}
                {{--                                                class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn"><i --}}
                {{--                                                    class="ri-close-fill fs-16"></i></button> --}}
                {{--                                        </div> --}}
                {{--                                    </div> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}
                {{--                        </div> --}}
                {{--                        <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border" --}}
                {{--                            id="checkout-elem"> --}}
                {{--                            <div class="d-flex justify-content-between align-items-center pb-3"> --}}
                {{--                                <h5 class="m-0 text-muted">Total:</h5> --}}
                {{--                                <div class="px-2"> --}}
                {{--                                    <h5 class="m-0" id="cart-item-total">$1258.58</h5> --}}
                {{--                                </div> --}}
                {{--                            </div> --}}

                {{--                            <a href="apps-ecommerce-checkout" class="btn btn-success text-center w-100"> --}}
                {{--                                Checkout --}}
                {{--                            </a> --}}
                {{--                        </div> --}}
                {{--                    </div> --}}
                {{--                </div> --}}

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        <span
                            class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ count($notifications) }}<span
                                class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge badge-soft-light fs-13"> {{ count($notifications) }}
                                            New</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                @if (count($notifications))
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        @foreach ($notifications as $item)
                                            <div
                                                class="text-reset notification-item d-block dropdown-item position-relative">
                                                <div class="d-flex">
                                                    <div class="flex-1">
                                                        <div class="fs-13 text-muted">
                                                            <p class="mb-1">{{ $item->message }}</p>
                                                        </div>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                                        </p>
                                                    </div>
                                                    {{-- <div class="px-2 fs-15"> --}}
                                                        {{-- <a href="{{ route('') }}"></a> --}}
                                                        {{-- <input class="form-check-input" type="checkbox"> --}}
                                                    {{-- </div> --}}
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="my-3 text-center">
                                            <a type="button" href="#"
                                                class="btn btn-soft-success waves-effect waves-light">View
                                                All Notifications <i class="ri-arrow-right-line align-middle"></i></a>
                                        </div>
                                    </div>
                                @else
                                    No new Notifications!
                                @endif

                            </div>
                        </div>
                    </div>
                </div>


                @guest
                    <a class="btn btn-outline-primary ms-2" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-outline-primary ms-2" href="{{ route('register') }}">Register</a>
                @endguest

                @auth
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                {!! \App\Helper\Helper::topbar_avatar(Auth::user()->avatar, Auth::user()->name) !!}
                                <span class="text-start ms-xl-2">
                                    <span
                                        class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome!</h6>

                            <a class="dropdown-item" href="{{ url('setting') }}">
                                <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Settings
                                </span>
                            </a>

                            <a class="dropdown-item " href="javascript:void(null);"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                    key="t-logout">@lang('translation.logout')</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>

                        </div>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</header>
