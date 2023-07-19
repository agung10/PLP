<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ $menuActive ? $menuActive->name : 'Home' }}
            </h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                @if(\Request::route()->getName() === 'dashboard')
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('') }}" class="text-muted text-hover-primary">
                           Home
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Dashboard</li>
                @endif

                @foreach($menus as $parent)
                    @if($parent['active'])
                        <li class="breadcrumb-item text-muted">
                            {{-- <a href="#" class="text-muted text-hover-primary"> --}}
                                {{ $parent['name'] }}
                            {{-- </a> --}}
                        </li>
                        @foreach($parent['menu'] as $menu)
                            @if($menu['active'])
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                </li>
                                <li class="breadcrumb-item text-muted">{{ $menu['name'] }}</li>
                                @foreach($menu['submenu'] as $submenu)
                                    @if($submenu['active'])
                                        <li class="breadcrumb-item">
                                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                        </li>
                                        <li class="breadcrumb-item text-muted">{{ $submenu['name'] }}</li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
