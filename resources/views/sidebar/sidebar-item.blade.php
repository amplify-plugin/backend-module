<li class="{{ $liClass }}">
    <a class="{{ $linkClass }}" href="{{ $item['url'] ?? '#' }}">
        @if(!empty($item['icon']))
            <i class="nav-icon {{ $item['icon'] }}"></i>
        @endif
        {{ is_array($item['label']) ? implode(' ', array_map(fn($l) => __($l), $item['label'])) : __($item['label']) }}
    </a>

    @if($hasChildren)
        <ul class="nav-dropdown-items" style="{{ $isOpen ? '' : 'display:none;' }}">
            @foreach($item['children'] as $child)
                <x-backend::sidebar-item :item="$child" />
            @endforeach
        </ul>
    @endif
</li>
