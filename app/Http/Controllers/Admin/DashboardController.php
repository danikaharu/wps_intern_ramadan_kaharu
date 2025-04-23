<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Activity; // Misalnya, model untuk log aktivitas
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        $user = auth()->user();

        $managers = collect();
        $staffs = collect();

        // Jika Direktur, tampilkan hanya manager yang menjadi bawahannya langsung
        if ($user->hasRole('Direktur')) {
            $managers = User::role(['Manager Keuangan', 'Manager Operasional'])
                ->where('supervisor_id', $user->id)
                ->get();
        }

        // Jika Manager Keuangan atau Manager Operasional, tampilkan hanya staff yang menjadi bawahannya langsung
        elseif ($user->hasRole('Manager Keuangan') || $user->hasRole('Manager Operasional')) {
            $staffs = User::role('Staff')
                ->where('supervisor_id', $user->id)
                ->get();
        }

        return view('admin.dashboard.index', compact('managers', 'staffs'));
    }


    public function calendarEvents(Request $request)
    {
        $user = Auth::user();
        $userId = $request->user_id;

        $query = Activity::query();

        // ID yang boleh diakses (awalnya hanya diri sendiri)
        $accessibleIds = [$user->id];

        // Jika Direktur, tambahkan semua manager yang diawasi (supervisor_id = direktur.id)
        if ($user->hasRole('Direktur')) {
            $managerIds = \App\Models\User::where('supervisor_id', $user->id)->pluck('id')->toArray();
            $accessibleIds = array_merge($accessibleIds, $managerIds);
        }

        // Jika Manager, tambahkan staff yang diawasi (supervisor_id = manager.id)
        if ($user->hasRole('Manager Keuangan') || $user->hasRole('Manager Operasional')) {
            $staffIds = \App\Models\User::where('supervisor_id', $user->id)->pluck('id')->toArray();
            $accessibleIds = array_merge($accessibleIds, $staffIds);
        }

        // Filter berdasarkan user_id yang dipilih
        if ($userId && in_array($userId, $accessibleIds)) {
            $query->where('user_id', $userId);
        } else {
            $query->whereIn('user_id', $accessibleIds);
        }

        $activities = $query->get();

        $events = $activities->map(function ($activity) {
            return [
                'title' => $activity->activity,
                'start' => $activity->date,
                'end'   => $activity->date,
                'url'   => route('admin.log.detail', $activity->id),
            ];
        });

        return response()->json($events);
    }


    // Menampilkan detail log
    public function showLogDetail($id)
    {
        $activity = Activity::find($id);

        if (!$activity) {
            abort(404);
        }

        return view('admin.dashboard.detail-log', compact('activity'));
    }
}
