<header id="header" class="header fixed-top d-flex align-items-center">
    <style>
        img.my-logos {
            margin-top: 5px !important;
            object-fit: cover !important;
            width: 20% !important;
            height: 40% !important;
        }
    </style>
    <div class="d-flex align-items-center justify-content-between">

        <img class="my-logos" src="{{ asset('assets/img/usni.png') }}" alt="">
        {{-- <p class="text-sm">Correspondence System</p> --}}
        <div class="col-5 text-center">
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>






    </div><!-- End Logo -->

    {{-- <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar --> --}}

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            {{-- <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li> --}}
            <!-- End Search Icon-->
            @if (auth('web')->user()->role == 'admin' || auth('web')->user()->role == 'staff')
                <li class="nav-item dropdown">
                    @php
                        $user = auth('web')->user()->id;
                        if (auth('web')->user()->role == 'admin' || auth('web')->user()->role == 'staff') {
                            $count = $count = \App\Models\Notification::join(
                                'users',
                                'users.id',
                                '=',
                                'notifications.receiver_id',
                            )
                                ->where('users.role', '!=', 'student')
                                ->where('status', 'unread')
                                ->count();
                            $unread = \App\Models\Notification::join(
                                'users',
                                'users.id',
                                '=',
                                'notifications.receiver_id',
                            )
                                ->join('inbox', 'inbox.id', '=', 'notifications.inbox_id')
                                ->join('users as sender', 'sender.id', '=', 'inbox.sender_id')
                                ->select(
                                    'notifications.*',
                                    'users.name as receiver_name',
                                    'inbox.id as inbox_id',
                                    'inbox.subject as inbox_subject',
                                    'sender.name as sender_name',
                                )
                                ->where('users.role', '!=', 'student')
                                ->where('notifications.status', 'unread')
                                ->get();
                        } elseif (auth('web')->user()->role == 'student') {
                            $count = \App\Models\Notification::join(
                                'users',
                                'users.id',
                                '=',
                                'notifications.receiver_id',
                            )
                                ->where('users.id', $user)
                                ->where('notifications.status', 'unread')
                                ->count();
                            $unread = \App\Models\Notification::join(
                                'users',
                                'users.id',
                                '=',
                                'notifications.receiver_id',
                            )
                                ->join('inbox', 'inbox.id', '=', 'notifications.inbox_id')
                                ->join('users as sender', 'sender.id', '=', 'inbox.sender_id')
                                ->select(
                                    'notifications.*',
                                    'users.name as receiver_name',
                                    'inbox.id as inbox_id',
                                    'inbox.subject as inbox_subject',
                                    'sender.name as sender_name',
                                )
                                ->where('users.id', $user)
                                ->where('notifications.status', 'unread')
                                ->get();
                        } elseif (auth('web')->user()->role == 'lecturer') {
                            $count = \App\Models\Notification::join(
                                'users',
                                'users.id',
                                '=',
                                'notifications.receiver_id',
                            )
                                ->where('users.id', $user)
                                ->where('notifications.status', 'unread')
                                ->count();
                            $unread = \App\Models\Notification::join(
                                'users',
                                'users.id',
                                '=',
                                'notifications.receiver_id',
                            )
                                ->join('inbox', 'inbox.id', '=', 'notifications.inbox_id')
                                ->join('users as sender', 'sender.id', '=', 'inbox.sender_id')
                                ->select(
                                    'notifications.*',
                                    'users.name as receiver_name',
                                    'inbox.id as inbox_id',
                                    'inbox.subject as inbox_subject',
                                    'sender.name as sender_name',
                                )
                                ->where('users.id', $user)
                                ->where('notifications.status', 'unread')
                                ->get();
                        }

                    @endphp
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">{{ $count }}</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">

                        <li class="dropdown-header">
                            @if ($count > 0)
                                You have {{ $count }} new notifications
                            @else
                                You have no new notifications
                            @endif
                            {{-- <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a> --}}
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        @forelse ($unread as $item)
                            <a href="{{ route('incoming-letter.show', $item->inbox_id) }}">
                                <li class="notification-item">
                                    <i class="bi bi-exclamation-circle text-warning"></i>
                                    <div>
                                        <h4>{{ $item->title }}</h4>
                                        <p>{{ $item->inbox_subject }}</p>
                                        <p>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                                        </p>
                                    </div>
                                </li>
                            </a>


                            <li>
                                <hr class="dropdown-divider">
                            </li>

                        @empty
                        @endforelse






                    </ul><!-- End Notification Dropdown Items -->

                </li>
            @endif

            <!-- End Notification Nav -->


            <li class="nav-item dropdown pe-3">
                @php
                    $check = Auth::user()->role;
                    if ($check == 'student') {
                        $student = App\Models\Student::where('user_id', Auth::user()->id)->first();
                        $image = $student->image;
                    } elseif ($check == 'lecturer') {
                        $lecturer = App\Models\Lecture::where('user_id', Auth::user()->id)->first();
                        $image = $lecturer->image;
                    } elseif ($check == 'staff') {
                        $staff = App\Models\Staff::where('user_id', Auth::user()->id)->first();
                        $image = $staff->image;
                    } else {
                        $image = null;
                    }

                @endphp
                <style>
                    .my-avatar {
                        width: 40px !important;
                        height: 40px !important;
                    }
                </style>
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    {{-- if $image null then img = placeholder from internet --}}
                    @if ($image == null)
                        <img src="{{ asset('assets/default-avatar.jpeg') }}">
                    @elseif ($image != null)
                        <img src="{{ asset('storage/' . $image) }}" alt="Profile" class="rounded-circle my-avatar">
                    @endif

                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->username }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->role }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @if (Auth::user()->role !== 'admin')
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.index') }}">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('profile.change-password') }}">
                            <i class="bi bi-gear"></i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>
