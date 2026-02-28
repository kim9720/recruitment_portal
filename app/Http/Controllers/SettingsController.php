<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SettingsController extends Controller
{
    /**
     * Display general settings page
     */
    public function general()
    {
        return view('settings.general');
    }

    /**
     * Update general settings
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'company_phone' => 'required|string|max:20',
            'company_address' => 'required|string|max:500',
            'auto_close_days' => 'required|integer|min:1|max:365',
            'max_applications' => 'required|integer|min:1',
            'default_job_status' => 'required|string|in:active,draft,pending',
            'allow_multiple_applications' => 'boolean',
            'require_resume' => 'boolean',
            'smtp_host' => 'required|string|max:255',
            'smtp_port' => 'required|integer',
            'from_email' => 'required|email|max:255',
            'from_name' => 'required|string|max:255',
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'notify_new_application' => 'boolean',
            'notify_interview' => 'boolean',
        ]);

        // Store settings in config or database
        // For now, we'll use a settings file approach
        $settingsPath = storage_path('app/settings.json');
        file_put_contents($settingsPath, json_encode($validated, JSON_PRETTY_PRINT));

        Log::info('General settings updated', ['user' => auth()->user()->email]);

        return redirect()->route('settings.general')
            ->with('success', 'General settings updated successfully!');
    }

    /**
     * Display user management page
     */
    public function users()
    {
        $users = User::with('roles')->paginate(10);

        $stats = [
            'total' => User::count(),
            'admins' => User::role('admin')->count(),
            'hr' => User::role('hr')->count(),
            'candidates' => User::role('candidate')->count(),
        ];

        return view('settings.user_management', compact('users', 'stats'));
    }

    /**
     * Store a new user
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:admin,hr,recruiter,candidate',
            'password' => 'required|string|min:8|confirmed',
            'send_welcome_email' => 'boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(), // Auto-verify admin-created users
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        // Send welcome email if requested
        if ($request->boolean('send_welcome_email')) {
        }

        Log::info('New user created', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $validated['role'],
            'created_by' => auth()->user()->email
        ]);

        return redirect()->route('settings.users')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display specific user details
     */
    public function showUser(User $user)
    {
        $user->load('roles', 'permissions');
        return view('settings.user-show', compact('user'));
    }

    /**
     * Update user details
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|in:admin,hr,recruiter,candidate',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user details
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        // Update role
        $user->syncRoles([$validated['role']]);

        Log::info('User updated', [
            'user_id' => $user->id,
            'email' => $user->email,
            'updated_by' => auth()->user()->email
        ]);

        return redirect()->route('settings.users')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->route('settings.users')
                ->with('error', 'You cannot delete your own account!');
        }

        // Prevent deleting the last admin
        if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->route('settings.users')
                ->with('error', 'Cannot delete the last admin user!');
        }

        $email = $user->email;
        $user->delete();

        Log::warning('User deleted', [
            'user_email' => $email,
            'deleted_by' => auth()->user()->email
        ]);

        return redirect()->route('settings.users')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Display permissions management page
     */
    public function permissions()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all()->groupBy(function ($permission) {
            // Group permissions by module (e.g., 'jobs.create' -> 'jobs')
            return explode('.', $permission->name)[0] ?? 'general';
        });

        $stats = [
            'admin_users' => User::role('admin')->count(),
            'hr_users' => User::role('hr')->count(),
            'recruiter_users' => User::role('hr')->count(),
            'candidate_users' => User::role('candidate')->count(),
        ];

        return view('settings.permission', compact('roles', 'permissions', 'stats'));
    }

    /**
     * Update role permissions
     */
    public function updatePermissions(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::findByName($validated['role']);
        $role->syncPermissions($validated['permissions']);

        Log::info('Permissions updated', [
            'role' => $validated['role'],
            'permissions_count' => count($validated['permissions']),
            'updated_by' => auth()->user()->email
        ]);

        return redirect()->route('settings.permissions')
            ->with('success', 'Permissions updated successfully!');
    }

    /**
     * Display system logs
     */
    public function logs(Request $request)
    {
        $level = $request->input('level');
        $dateRange = $request->input('date_range', 'today');
        $category = $request->input('category');
        $search = $request->input('search');

        // In a real application, you'd query from a logs table
        // For this example, we'll read from Laravel's log file
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            $logLines = explode("\n", $logContent);

            // Parse and filter logs (simplified version)
            foreach (array_reverse(array_slice($logLines, -100)) as $line) {
                if (empty(trim($line))) continue;

                // Simple log parsing (you should use a proper log parser)
                preg_match('/\[(.*?)\]\s+(\w+)\.\w+:\s+(.*)/', $line, $matches);

                if (count($matches) >= 4) {
                    $log = [
                        'timestamp' => $matches[1] ?? now(),
                        'level' => strtolower($matches[2] ?? 'info'),
                        'message' => $matches[3] ?? $line,
                        'category' => 'system',
                        'user' => 'system',
                    ];

                    // Apply filters
                    if ($level && $log['level'] !== $level) continue;
                    if ($search && stripos($log['message'], $search) === false) continue;

                    $logs[] = $log;
                }
            }
        }

        // Mock data for better demonstration
        $logs = $this->getMockLogs();

        $stats = [
            'info' => collect($logs)->where('level', 'info')->count(),
            'warning' => collect($logs)->where('level', 'warning')->count(),
            'error' => collect($logs)->where('level', 'error')->count(),
            'time_range' => '24h',
        ];

        return view('settings.system_logs', compact('logs', 'stats'));
    }

    /**
     * Export system logs
     */
    public function exportLogs(Request $request)
    {
        $logs = $this->getMockLogs();

        $filename = 'system-logs-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Level', 'Timestamp', 'Category', 'User', 'Message']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log['level'],
                    $log['timestamp'],
                    $log['category'],
                    $log['user'],
                    $log['message'],
                ]);
            }

            fclose($file);
        };

        Log::info('System logs exported', ['user' => auth()->user()->email]);

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get mock logs for demonstration
     */
    private function getMockLogs()
    {
        return [
            [
                'level' => 'info',
                'timestamp' => now()->subMinutes(2)->format('Y-m-d H:i:s'),
                'category' => 'Authentication',
                'user' => 'john.doe@example.com',
                'message' => 'User logged in successfully',
            ],
            [
                'level' => 'success',
                'timestamp' => now()->subMinutes(6)->format('Y-m-d H:i:s'),
                'category' => 'Jobs',
                'user' => 'jane.smith@example.com',
                'message' => 'New job posting created: Senior Developer',
            ],
            [
                'level' => 'warning',
                'timestamp' => now()->subMinutes(17)->format('Y-m-d H:i:s'),
                'category' => 'Applications',
                'user' => 'system',
                'message' => 'Application processing delayed due to high volume',
            ],
            [
                'level' => 'error',
                'timestamp' => now()->subMinutes(22)->format('Y-m-d H:i:s'),
                'category' => 'System',
                'user' => 'system',
                'message' => 'Failed to send email notification to candidate',
            ],
            [
                'level' => 'info',
                'timestamp' => now()->subMinutes(27)->format('Y-m-d H:i:s'),
                'category' => 'Users',
                'user' => 'admin@example.com',
                'message' => 'New user account created: mike.johnson@example.com',
            ],
            [
                'level' => 'success',
                'timestamp' => now()->subMinutes(34)->format('Y-m-d H:i:s'),
                'category' => 'Applications',
                'user' => 'candidate@example.com',
                'message' => 'Application submitted for Web Developer position',
            ],
            [
                'level' => 'info',
                'timestamp' => now()->subMinutes(47)->format('Y-m-d H:i:s'),
                'category' => 'Authentication',
                'user' => 'sarah.williams@example.com',
                'message' => 'Password changed successfully',
            ],
            [
                'level' => 'warning',
                'timestamp' => now()->subMinutes(62)->format('Y-m-d H:i:s'),
                'category' => 'System',
                'user' => 'system',
                'message' => 'Database connection pool nearing capacity',
            ],
        ];
    }
}
