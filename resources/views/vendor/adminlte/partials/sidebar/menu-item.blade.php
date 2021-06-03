@inject('menuItemHelper', \JeroenNoten\LaravelAdminLte\Helpers\MenuItemHelper)

@if ($menuItemHelper->isHeader($item))

    {{-- Header --}}
    <li @if(isset($item['id'])) id="{{ $item['id'] }}" @endif class="nav-header">
        {{ is_string($item) ? $item : $item['header'] }}
    </li>

<<<<<<< HEAD
{{-- @elseif ($menuItemHelper->isSearchBar($item)) --}}

    {{-- Search form --}}
    {{-- @include('adminlte::partials.sidebar.menu-item-search-form') --}}

=======
{{--@elseif ($menuItemHelper->isSearchBar($item))--}}

    {{-- Search form --}}
{{--    @include('adminlte::partials.sidebar.menu-item-search-form')--}}
>>>>>>> 462de4eb8a741061ebcae06de9e6ebbbf349b2ac

@elseif ($menuItemHelper->isSubmenu($item))

    {{-- Treeview menu --}}
    @include('adminlte::partials.sidebar.menu-item-treeview-menu')

@elseif ($menuItemHelper->isLink($item))

    {{-- Link --}}
    @include('adminlte::partials.sidebar.menu-item-link')

@endif
