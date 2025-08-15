<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            });
        }
        
        // Filter by registration date
        if ($request->has('from_date') && $request->input('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }
        
        if ($request->has('to_date') && $request->input('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show user details
     */
    public function show($id)
    {
        $user = User::with('leiRegistrations')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Base validation rules
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'is_active' => 'boolean'
        ];
        
        // Add password validation if changing password
        if ($request->has('change_password') && $request->change_password == '1') {
            $rules['password'] = 'required|string|min:8|confirmed';
        }
        
        $validated = $request->validate($rules);
        
        // Prepare data for update
        $updateData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'company_name' => $validated['company_name'],
            'phone' => $validated['phone'],
            'is_active' => $request->has('is_active') ? true : false
        ];
        
        // Update the full name
        $updateData['name'] = trim($validated['first_name'] . ' ' . $validated['last_name']);
        
        // Add password to update data if changing
        if ($request->has('change_password') && $request->change_password == '1' && !empty($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        // Update the user
        $user->update($updateData);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully' . 
                ($request->has('change_password') && $request->change_password == '1' ? ' and password has been changed.' : '.'));
    }
    /**
     * Delete user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Check if user has any LEI registrations
        if ($user->leiRegistrations()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete user with existing LEI registrations');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
    
    /**
     * Export users to CSV
     */
    public function exportCsv()
    {
        return Excel::download(new UsersExport, 'users_' . date('Y-m-d_His') . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    
    /**
     * Export users to Excel
     */
    public function exportXlsx()
    {
        return Excel::download(new UsersExport, 'users_' . date('Y-m-d_His') . '.xlsx');
    }
    
    /**
     * Toggle user status
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        // Add is_active column to users table if not exists
        $user->is_active = !($user->is_active ?? true);
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'User status updated successfully'
        ]);
    }
}