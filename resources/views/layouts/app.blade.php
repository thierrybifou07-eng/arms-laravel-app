<!doctype html>

<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="{{ asset('admin-template/assets') }}/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin-template/assets') }}/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('admin-template/assets') }}/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('admin-template/assets') }}/vendor/css/core.css" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets') }}/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet"
        href="{{ asset('admin-template/assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <link rel="stylesheet" href="{{ asset('admin-template/assets') }}/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('admin-template/assets') }}/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('admin-template/assets') }}/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="{{ url('/') }}" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <span class="text-primary">
                                <svg width="25" viewBox="0 0 25 42" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs>
                                        <path
                                            d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                                            id="path-1"></path>
                                        <path
                                            d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                                            id="path-3"></path>
                                        <path
                                            d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                                            id="path-4"></path>
                                        <path
                                            d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                                            id="path-5"></path>
                                    </defs>
                                    <g id="g-app-brand" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd">
                                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                            <g id="Icon" transform="translate(27.000000, 15.000000)">
                                                <g id="Mask" transform="translate(0.000000, 8.000000)">
                                                    <mask id="mask-2" fill="white">
                                                        <use xlink:href="#path-1"></use>
                                                    </mask>
                                                    <use fill="currentColor" xlink:href="#path-1"></use>
                                                    <g id="Path-3" mask="url(#mask-2)">
                                                        <use fill="currentColor" xlink:href="#path-3"></use>
                                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3">
                                                        </use>
                                                    </g>
                                                    <g id="Path-4" mask="url(#mask-2)">
                                                        <use fill="currentColor" xlink:href="#path-4"></use>
                                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4">
                                                        </use>
                                                    </g>
                                                </g>
                                                <g id="Triangle"
                                                    transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                                    <use fill="currentColor" xlink:href="#path-5"></use>
                                                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold ms-2">ArmS</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
                    </a>
                </div>

                <div class="menu-divider mt-0"></div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Dashboards -->
                    <li class="menu-item active">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons bx bx-home-smile"></i>
                            <div class="text-truncate" data-i18n="Dashboards">Dashboard</div>
                            <span class="badge rounded-pill bg-danger ms-auto">5</span>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item active">
                                <a href="index.html" class="menu-link">
                                    <div class="text-truncate" data-i18n="Analytics">Analytics</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/dashboards-crm.html"
                                    target="_blank" class="menu-link">
                                    <div class="text-truncate" data-i18n="CRM">CRM</div>

                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-ecommerce-dashboard.html"
                                    target="_blank" class="menu-link">
                                    <div class="text-truncate" data-i18n="eCommerce">eCommerce</div>

                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-logistics-dashboard.html"
                                    target="_blank" class="menu-link">
                                    <div class="text-truncate" data-i18n="Logistics">Logistics</div>

                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/html/vertical-menu-template/app-academy-dashboard.html"
                                    target="_blank" class="menu-link">
                                    <div class="text-truncate" data-i18n="Academy">Academy</div>

                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- Residences -->
                    <!-- Academy menu start -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-book-open"></i>
                            <div data-i18n="Academy">Residences</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('residences.index') }}" class="menu-link">
                                    <div data-i18n="Dashboard">Residence</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="" class="menu-link">
                                    <div data-i18n="My Course">Building</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-academy-course-details.html" class="menu-link">
                                    <div data-i18n="Course Details">Floor</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-academy-course-details.html" class="menu-link">
                                    <div data-i18n="Course Details">Rooms</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Academy menu end -->
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-car"></i>
                            <div data-i18n="Logistics">Logistics</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="app-logistics-dashboard.html" class="menu-link">
                                    <div data-i18n="Dashboard">Dashboard</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-logistics-fleet.html" class="menu-link">
                                    <div data-i18n="Fleet">Fleet</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-food-menu"></i>
                            <div data-i18n="Invoice">Invoice</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="app-invoice-list.html" class="menu-link">
                                    <div data-i18n="List">List</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-invoice-preview.html" class="menu-link">
                                    <div data-i18n="Preview">Preview</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-invoice-edit.html" class="menu-link">
                                    <div data-i18n="Edit">Edit</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="app-invoice-add.html" class="menu-link">
                                    <div data-i18n="Add">Add</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-user"></i>
                            <div data-i18n="Users">Users</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('users.index') }}" class="menu-link">
                                    <div data-i18n="List">List</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="View">View</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="app-user-view-account.html" class="menu-link">
                                            <div data-i18n="Account">Account</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="app-user-view-security.html" class="menu-link">
                                            <div data-i18n="Security">Security</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="app-user-view-billing.html" class="menu-link">
                                            <div data-i18n="Billing &amp; Plans">Billing &amp; Plans</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="app-user-view-notifications.html" class="menu-link">
                                            <div data-i18n="Notifications">Notifications</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="app-user-view-connections.html" class="menu-link">
                                            <div data-i18n="Connections">Connections</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-check-shield"></i>
                            <div data-i18n="Roles &amp; Permissions">Roles &amp; Permissions</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="{{ route('roles.index') }}" class="menu-link">
                                    <div data-i18n="Roles">Roles</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('permissions.index') }}" class="menu-link">
                                    <div data-i18n="Permission">Permission</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-dock-top"></i>
                            <div data-i18n="Pages">Pages</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="User Profile">User Profile</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="pages-profile-user.html" class="menu-link">
                                            <div data-i18n="Profile">Profile</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-profile-teams.html" class="menu-link">
                                            <div data-i18n="Teams">Teams</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-profile-projects.html" class="menu-link">
                                            <div data-i18n="Projects">Projects</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-profile-connections.html" class="menu-link">
                                            <div data-i18n="Connections">Connections</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Account Settings">Account Settings</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="pages-account-settings-account.html" class="menu-link">
                                            <div data-i18n="Account">Account</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-account-settings-security.html" class="menu-link">
                                            <div data-i18n="Security">Security</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-account-settings-billing.html" class="menu-link">
                                            <div data-i18n="Billing &amp; Plans">Billing &amp; Plans</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-account-settings-notifications.html" class="menu-link">
                                            <div data-i18n="Notifications">Notifications</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-account-settings-connections.html" class="menu-link">
                                            <div data-i18n="Connections">Connections</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="pages-faq.html" class="menu-link">
                                    <div data-i18n="FAQ">FAQ</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-pricing.html" class="menu-link">
                                    <div data-i18n="Pricing">Pricing</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Misc">Misc</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="pages-misc-error.html" class="menu-link" target="_blank">
                                            <div data-i18n="Error">Error</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-misc-under-maintenance.html" class="menu-link"
                                            target="_blank">
                                            <div data-i18n="Under Maintenance">Under Maintenance</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-misc-comingsoon.html" class="menu-link" target="_blank">
                                            <div data-i18n="Coming Soon">Coming Soon</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="pages-misc-not-authorized.html" class="menu-link" target="_blank">
                                            <div data-i18n="Not Authorized">Not Authorized</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class="menu-icon icon-base bx bx-lock-open-alt"></i>
                            <div data-i18n="Authentications">Authentications</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Login">Login</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-login-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-login-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Register">Register</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-register-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-register-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-register-multisteps.html" class="menu-link" target="_blank">
                                            <div data-i18n="Multi-steps">Multi-steps</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Verify Email">Verify Email</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-verify-email-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-verify-email-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Reset Password">Reset Password</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-reset-password-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-reset-password-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Forgot Password">Forgot Password</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-forgot-password-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="javascript:void(0);" class="menu-link menu-toggle">
                                    <div data-i18n="Two Steps">Two Steps</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item">
                                        <a href="auth-two-steps-basic.html" class="menu-link" target="_blank">
                                            <div data-i18n="Basic">Basic</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="auth-two-steps-cover.html" class="menu-link" target="_blank">
                                            <div data-i18n="Cover">Cover</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar">





                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0   d-xl-none ">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base bx bx-menu icon-md"></i>
                        </a>
                    </div>


                    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">

                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                    <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete">
                                        <div class="aa-Autocomplete" role="combobox" aria-expanded="false"
                                            aria-haspopup="listbox" aria-labelledby="autocomplete-0-label"><button
                                                type="button" class="aa-DetachedSearchButton" title="Search"
                                                id="autocomplete-0-label">
                                                <div class="aa-DetachedSearchButtonIcon"><svg class="aa-SubmitIcon"
                                                        viewBox="0 0 24 24" width="20" height="20"
                                                        fill="currentColor">
                                                        <path
                                                            d="M16.041 15.856c-0.034 0.026-0.067 0.055-0.099 0.087s-0.060 0.064-0.087 0.099c-1.258 1.213-2.969 1.958-4.855 1.958-1.933 0-3.682-0.782-4.95-2.050s-2.050-3.017-2.050-4.95 0.782-3.682 2.050-4.95 3.017-2.050 4.95-2.050 3.682 0.782 4.95 2.050 2.050 3.017 2.050 4.95c0 1.886-0.745 3.597-1.959 4.856zM21.707 20.293l-3.675-3.675c1.231-1.54 1.968-3.493 1.968-5.618 0-2.485-1.008-4.736-2.636-6.364s-3.879-2.636-6.364-2.636-4.736 1.008-6.364 2.636-2.636 3.879-2.636 6.364 1.008 4.736 2.636 6.364 3.879 2.636 6.364 2.636c2.125 0 4.078-0.737 5.618-1.968l3.675 3.675c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414z">
                                                        </path>
                                                    </svg></div>
                                                <div class="aa-DetachedSearchButtonPlaceholder">Search [CTRL + K]</div>
                                                <div class="aa-DetachedSearchButtonQuery"></div>
                                            </button></div>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                            <!-- Place this tag where you want the button to render. -->
                            <li class="nav-item lh-1 me-4">
                                <a class="github-button"
                                    href="https://github.com/themeselection/sneat-bootstrap-html-admin-template-free"
                                    data-icon="octicon-star" data-size="large" data-show-count="true"
                                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">{{ Auth::user()->name }}</a>
                            </li>




                            <ul class="navbar-nav flex-row align-items-center ms-md-auto">



                                <!-- Language -->
                                <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown">
                                        <i class="icon-base bx bx-globe icon-md"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item active" href="javascript:void(0);"
                                                data-language="en" data-text-direction="ltr">
                                                <span>English</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-language="fr"
                                                data-text-direction="ltr">
                                                <span>French</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-language="ar"
                                                data-text-direction="rtl">
                                                <span>Arabic</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" data-language="de"
                                                data-text-direction="ltr">
                                                <span>German</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ Language -->


                                <!-- Style Switcher -->
                                <li class="nav-item dropdown me-2 me-xl-0">
                                    <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme"
                                        href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-label="Toggle theme (dark)">
                                        <i class="bx-moon icon-base bx icon-md theme-icon-active"></i>
                                        <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                                        <li>
                                            <button type="button" class="dropdown-item align-items-center"
                                                data-bs-theme-value="light" aria-pressed="false">
                                                <span><i class="icon-base bx bx-sun icon-md me-3"
                                                        data-icon="sun"></i>Light</span>
                                            </button>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item align-items-center active"
                                                data-bs-theme-value="dark" aria-pressed="true">
                                                <span><i class="icon-base bx bx-moon icon-md me-3"
                                                        data-icon="moon"></i>Dark</span>
                                            </button>
                                        </li>
                                    </ul>
                                </li>
                                <!-- / Style Switcher-->


                                <!-- Quick links  -->
                                <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        <i class="icon-base bx bx-grid-alt icon-md"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end p-0">
                                        <div class="dropdown-menu-header border-bottom">
                                            <div class="dropdown-header d-flex align-items-center py-3">
                                                <h6 class="mb-0 me-auto">Shortcuts</h6>
                                                <a href="javascript:void(0)" class="dropdown-shortcuts-add py-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    aria-label="Add shortcuts"
                                                    data-bs-original-title="Add shortcuts"><i
                                                        class="icon-base bx bx-plus-circle text-heading"></i></a>
                                            </div>
                                        </div>
                                        <div class="dropdown-shortcuts-list scrollable-container ps">
                                            <div class="row row-bordered overflow-visible g-0">
                                                <div class="dropdown-shortcuts-item col">
                                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                        <i class="icon-base bx bx-calendar icon-26px text-heading"></i>
                                                    </span>
                                                    <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                                    <small>Appointments</small>
                                                </div>
                                                <div class="dropdown-shortcuts-item col">
                                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                        <i
                                                            class="icon-base bx bx-food-menu icon-26px text-heading"></i>
                                                    </span>
                                                    <a href="app-invoice-list.html" class="stretched-link">Invoice
                                                        App</a>
                                                    <small>Manage Accounts</small>
                                                </div>
                                            </div>
                                            <div class="row row-bordered overflow-visible g-0">
                                                <div class="dropdown-shortcuts-item col">
                                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                        <i class="icon-base bx bx-user icon-26px text-heading"></i>
                                                    </span>
                                                    <a href="app-user-list.html" class="stretched-link">User App</a>
                                                    <small>Manage Users</small>
                                                </div>
                                                <div class="dropdown-shortcuts-item col">
                                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                        <i
                                                            class="icon-base bx bx-check-shield icon-26px text-heading"></i>
                                                    </span>
                                                    <a href="app-access-roles.html" class="stretched-link">Role
                                                        Management</a>
                                                    <small>Permission</small>
                                                </div>
                                            </div>
                                            <div class="row row-bordered overflow-visible g-0">
                                                <div class="dropdown-shortcuts-item col">
                                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                        <i
                                                            class="icon-base bx bx-pie-chart-alt-2 icon-26px text-heading"></i>
                                                    </span>
                                                    <a href="index.html" class="stretched-link">Dashboard</a>
                                                    <small>User Dashboard</small>
                                                </div>
                                                <div class="dropdown-shortcuts-item col">
                                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                        <i class="icon-base bx bx-cog icon-26px text-heading"></i>
                                                    </span>
                                                    <a href="{{ route('profile.update') }}"
                                                        class="stretched-link">Setting</a>
                                                    <small>Account Settings</small>
                                                </div>
                                            </div>
                                            <div class="row row-bordered overflow-visible g-0">
                                                <div class="dropdown-shortcuts-item col">
                                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                        <i
                                                            class="icon-base bx bx-help-circle icon-26px text-heading"></i>
                                                    </span>
                                                    <a href="pages-faq.html" class="stretched-link">FAQs</a>
                                                    <small>FAQs &amp; Articles</small>
                                                </div>
                                                <div class="dropdown-shortcuts-item col">
                                                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                        <i
                                                            class="icon-base bx bx-window-open icon-26px text-heading"></i>
                                                    </span>
                                                    <a href="modal-examples.html" class="stretched-link">Modals</a>
                                                    <small>Useful Popups</small>
                                                </div>
                                            </div>
                                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                <div class="ps__thumb-x" tabindex="0"
                                                    style="left: 0px; width: 0px;"></div>
                                            </div>
                                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                <div class="ps__thumb-y" tabindex="0"
                                                    style="top: 0px; height: 0px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- Quick links -->

                                <!-- Notification -->
                                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        <span class="position-relative">
                                            <i class="icon-base bx bx-bell icon-md"></i>
                                            <span
                                                class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end p-0">
                                        <li class="dropdown-menu-header border-bottom">
                                            <div class="dropdown-header d-flex align-items-center py-3">
                                                <h6 class="mb-0 me-auto">Notification</h6>
                                                <div class="d-flex align-items-center h6 mb-0">
                                                    <span class="badge bg-label-primary me-2">8 New</span>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-all p-2"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        aria-label="Mark all as read"
                                                        data-bs-original-title="Mark all as read"><i
                                                            class="icon-base bx bx-envelope-open text-heading"></i></a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dropdown-notifications-list scrollable-container ps">
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <img src="{{ asset('admin-template/assets') }}/img/avatars/1.png"
                                                                    alt="" class="rounded-circle">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">Congratulation Lettie 🎉</h6>
                                                            <small class="mb-1 d-block text-body">Won the monthly best
                                                                seller gold badge</small>
                                                            <small class="text-body-secondary">1h ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-danger">CF</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">Charles Franklin</h6>
                                                            <small class="mb-1 d-block text-body">Accepted your
                                                                connection</small>
                                                            <small class="text-body-secondary">12hr ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <img src="{{ asset('admin-template/assets') }}/img/avatars/2.png"
                                                                    alt="" class="rounded-circle">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">New Message ✉️</h6>
                                                            <small class="mb-1 d-block text-body">You have new message
                                                                from
                                                                Natalie</small>
                                                            <small class="text-body-secondary">1h ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-success"><i
                                                                        class="icon-base bx bx-cart"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">Whoo! You have new order 🛒</h6>
                                                            <small class="mb-1 d-block text-body">ACME Inc. made new
                                                                order
                                                                $1,154</small>
                                                            <small class="text-body-secondary">1 day ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <img src="{{ asset('admin-template/assets') }}/img/avatars/9.png"
                                                                    alt="" class="rounded-circle">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">Application has been approved 🚀
                                                            </h6>
                                                            <small class="mb-1 d-block text-body">Your ABC project
                                                                application has been approved.</small>
                                                            <small class="text-body-secondary">2 days ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-success"><i
                                                                        class="icon-base bx bx-pie-chart-alt"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">Monthly report is generated</h6>
                                                            <small class="mb-1 d-block text-body">July monthly
                                                                financial
                                                                report is generated </small>
                                                            <small class="text-body-secondary">3 days ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <img src="{{ asset('admin-template/assets') }}/img/avatars/5.png"
                                                                    alt="" class="rounded-circle">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">Send connection request</h6>
                                                            <small class="mb-1 d-block text-body">Peter sent you
                                                                connection
                                                                request</small>
                                                            <small class="text-body-secondary">4 days ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <img src="{{ asset('admin-template/assets') }}/img/avatars/6.png"
                                                                    alt="" class="rounded-circle">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">New message from Jane</h6>
                                                            <small class="mb-1 d-block text-body">Your have new message
                                                                from
                                                                Jane</small>
                                                            <small class="text-body-secondary">5 days ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <span
                                                                    class="avatar-initial rounded-circle bg-label-warning"><i
                                                                        class="icon-base bx bx-error"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">CPU is running high</h6>
                                                            <small class="mb-1 d-block text-body">CPU Utilization
                                                                Percent is
                                                                currently at 88.63%,</small>
                                                            <small class="text-body-secondary">5 days ago</small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-read"><span
                                                                    class="badge badge-dot"></span></a>
                                                            <a href="javascript:void(0)"
                                                                class="dropdown-notifications-archive"><span
                                                                    class="icon-base bx bx-x"></span></a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                                <div class="ps__thumb-x" tabindex="0"
                                                    style="left: 0px; width: 0px;"></div>
                                            </div>
                                            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                                <div class="ps__thumb-y" tabindex="0"
                                                    style="top: 0px; height: 0px;"></div>
                                            </div>
                                        </li>
                                        <li class="border-top">
                                            <div class="d-grid p-4">
                                                <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                                    <small class="align-middle">View all notifications</small>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                                <!--/ Notification -->
                                <!-- User -->
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                        data-bs-toggle="dropdown">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('admin-template/assets') }}/img/avatars/1.png"
                                                alt="" class="rounded-circle">
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="{{ asset('admin-template/assets') }}/img/avatars/1.png"
                                                                alt="" class="w-px-40 h-auto rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">John Doe</h6>
                                                        <small class="text-body-secondary">Admin</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider my-1"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-profile-user.html"> <i
                                                    class="icon-base bx bx-user icon-md me-3"></i><span>My
                                                    Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}"> <i
                                                    class="icon-base bx bx-cog icon-md me-3"></i><span>Settings</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-account-settings-billing.html">
                                                <span class="d-flex align-items-center align-middle">
                                                    <i
                                                        class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i><span
                                                        class="flex-grow-1 align-middle">Billing Plan</span>
                                                    <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider my-1"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                                <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log
                                                    Out</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @method('')
                                                @csrf
                                            </form>

                                        </li>
                                    </ul>
                                </li>
                                <!--/ User -->

                            </ul>
                    </div>

                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!--content-->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-xxl-12 mb-6 order-0">

                                @yield('content')
                            </div>
                        </div>
                        
                    </div>
                </div>

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl">
                        <div
                            class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column mb-0">
                            <div class="mb-2 mb-md-0">
                                &#169;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                , made with ❤️ by
                                <a href="https://themeselection.com" target="_blank"
                                    class="footer-link">ThemeSelection</a>
                            </div>
                            <div class="d-none d-lg-inline-block">
                                <a href="https://themeselection.com/item/category/admin-templates/" target="_blank"
                                    class="footer-link me-4">Admin Templates</a>

                                <a href="https://themeselection.com/license/" class="footer-link me-4"
                                    target="_blank">License</a>
                                <a href="https://themeselection.com/item/category/bootstrap-admin-templates/"
                                    target="_blank" class="footer-link me-4">Bootstrap Dashboard</a>

                                <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                                    target="_blank" class="footer-link me-4">Documentation</a>

                                <a href="https://github.com/themeselection/sneat-bootstrap-html-admin-template-free/issues"
                                    target="_blank" class="footer-link">Support</a>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->

    <script src="{{ asset('admin-template/assets') }}/vendor/libs/jquery/jquery.js"></script>

    <script src="{{ asset('admin-template/assets') }}/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('admin-template/assets') }}/vendor/js/bootstrap.js"></script>

    <script src="{{ asset('admin-template/assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('admin-template/assets') }}/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('admin-template/assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->

    <script src="{{ asset('admin-template/assets') }}/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('admin-template/assets') }}/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
