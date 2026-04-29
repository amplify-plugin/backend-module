<li class="{{ $liClass }}">
    <a class="{{ $linkClass }}" href="{{ $item['url'] ?? '#' }}">
        @if(!empty($item['icon']))
            <i class="nav-icon {{ $item['icon'] }}"></i>
        @endif
        {{ __($item['label']) }}
    </a>

    @if($hasChildren)
        <ul class="nav-dropdown-items">
            @foreach($item['children'] as $child)
                <x-backend::link :item="$child" />
            @endforeach
        </ul>
    @endif
</li>
