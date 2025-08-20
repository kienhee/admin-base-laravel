@php
    $menuItems = config('menu');
    /**
     * Kiểm tra url có được active không
     * @param mixed $child
     * @return bool
     */
    if (!function_exists('isOpenMenu')) {
        function isOpenMenu($child)
        {
            return route($child['url']) == url()->current();
        }
    }
    if (!function_exists('hasActiveChild')) {
        /**
         * Kiểm tra phần tử con có active hay không
         * @param array $children
         * @return bool
         */
        function hasActiveChild($children = [])
        {
            foreach ($children as $child) {
                if (isOpenMenu($child))
                    return true;
            }
        }
    }



@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{route("admin.dashboard.analytics")}}" class="app-brand-link">
            @include('admin.components.logo')
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        @foreach ($menuItems as $item)
            @if (empty($item['children']))
                <li class="menu-item {{isOpenMenu($item) ? "active" : ""}}">
                    <a href="{{route($item['url'])}}" class="menu-link">
                        <i class="menu-icon tf-icons bx {{$item['icon']}}"></i>
                        <div class="text-truncate">{{$item['title']}}</div>
                    </a>
                </li>
            @else
                <li class="menu-item {{ hasActiveChild($item['children']) ? 'active open' : '' }}">
                    <a href="{{!empty($item['url']) ? route($item['url']) : 'javascript:void(0);'}}"
                        class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx {{$item['icon']}}"></i>
                        <div class="text-truncate">{{$item['title']}}</div>
                        @if(!empty($item['badge']))
                            <span class="badge badge-center rounded-pill bg-danger ms-auto">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                    </a>
                    <ul class="menu-sub">
                        @foreach ($item['children'] as $child)
                            <li class="menu-item {{isOpenMenu($child) ? "active" : ""}}">
                                <a href="{{$child['url'] ? route($child['url']) : 'javascript:void(0);'}}" class="menu-link">
                                    <div class="text-truncate">{{$child['title']}}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif



        @endforeach
    </ul>
</aside>
