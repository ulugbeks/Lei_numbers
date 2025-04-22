<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    /**
     * Display a listing of menus
     */
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu
     */
    public function create()
    {
        return view('admin.menus.create');
    }

    /**
     * Store a newly created menu
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:menus',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        Menu::create($validated);

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu created successfully');
    }

    /**
     * Show the menu and its items
     */
    public function show(Menu $menu)
    {
        $menuItems = $menu->rootItems()->with('children')->get();
        return view('admin.menus.show', compact('menu', 'menuItems'));
    }

    /**
     * Show the form for editing the menu
     */
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    /**
     * Update the menu
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('menus')->ignore($menu->id)
            ],
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        $menu->update($validated);

        return back()->with('success', 'Menu updated successfully');
    }

    /**
     * Remove the menu
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu deleted successfully');
    }

    /**
     * Show menu items management interface
     */
    public function items(Menu $menu)
    {
        $menuItems = $menu->rootItems()->with('children')->get();
        $allMenuItems = $menu->items()->get();
        return view('admin.menus.items', compact('menu', 'menuItems', 'allMenuItems'));
    }

    /**
     * Store a new menu item
     */
    public function storeItem(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'target' => 'nullable|string|in:_self,_blank',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        // Set default order if not provided
        if (!isset($validated['order'])) {
            $maxOrder = $menu->items()
                ->where('parent_id', $validated['parent_id'] ?? null)
                ->max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        $menu->items()->create($validated);

        return back()->with('success', 'Menu item added successfully');
    }

    /**
     * Update menu item
     */
    public function updateItem(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'route_name' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'target' => 'nullable|string|in:_self,_blank',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        // Prevent setting the item as its own parent
        if (isset($validated['parent_id']) && $validated['parent_id'] == $menuItem->id) {
            return back()->with('error', 'A menu item cannot be its own parent');
        }

        $menuItem->update($validated);

        return back()->with('success', 'Menu item updated successfully');
    }

    /**
     * Delete menu item
     */
    public function destroyItem(MenuItem $menuItem)
    {
        $menu = $menuItem->menu;
        $menuItem->delete();
        
        return redirect()->route('admin.menus.items', $menu)
            ->with('success', 'Menu item deleted successfully');
    }

    /**
     * Reorder menu items
     */
    public function reorderItems(Request $request)
    {
        $items = $request->input('items', []);
        
        foreach ($items as $id => $data) {
            $menuItem = MenuItem::find($id);
            if ($menuItem) {
                $menuItem->update([
                    'parent_id' => $data['parent_id'] ?? null,
                    'order' => $data['order'] ?? 0,
                ]);
            }
        }
        
        return response()->json(['success' => true]);
    }
}