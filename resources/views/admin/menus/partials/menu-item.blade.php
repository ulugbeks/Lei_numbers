<li class="list-group-item" data-id="{{ $item->id }}">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            @if($item->icon)
                <i class="{{ $item->icon }}"></i>
            @endif
            <span>{{ $item->title }}</span>
            
            @if($item->hasChildren())
                <span class="badge badge-info">{{ $item->children->count() }} items</span>
            @endif
        </div>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-info edit-item" 
                    data-id="{{ $item->id }}"
                    data-title="{{ $item->title }}"
                    data-url="{{ $item->url ?? '' }}"
                    data-route="{{ $item->route_name ?? '' }}"
                    data-icon="{{ $item->icon ?? '' }}"
                    data-target="{{ $item->target }}"
                    data-parent="{{ $item->parent_id ?? '' }}"
                    data-order="{{ $item->order }}"
                    data-active="{{ $item->active ? '1' : '0' }}">
                <i class="fas fa-edit"></i> Edit
            </button>
            <form action="{{ route('admin.menus.items.destroy', $item) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this menu item?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    
    @if($item->hasChildren())
        <ul class="list-group mt-2 menu-items-sortable">
            @foreach($item->children as $child)
                @include('admin.menus.partials.menu-item', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>