<ul class="navigation">
    @foreach($menuItems as $item)
        <li class="{{ request()->is(ltrim($item->url, '/')) ? 'active' : '' }}">
            <a href="{{ $item->url }}" @if($item->target == '_blank') target="_blank" @endif>
                @if($item->icon)
                    <i class="{{ $item->icon }}"></i>
                @endif
                {{ $item->title }}
            </a>
            
            @if($item->hasChildren())
                <ul>
                    @foreach($item->children as $child)
                        <li class="{{ request()->is(ltrim($child->url, '/')) ? 'active' : '' }}">
                            <a href="{{ $child->url }}" @if($child->target == '_blank') target="_blank" @endif>
                                @if($child->icon)
                                    <i class="{{ $child->icon }}"></i>
                                @endif
                                {{ $child->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>