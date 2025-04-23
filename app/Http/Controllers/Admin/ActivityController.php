<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Yajra\DataTables\Facades\DataTables;

class ActivityController extends Controller implements HasMiddleware
{


    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('view activity'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('create activity'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('show activity'), only: ['show']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('edit activity'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete activity'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('verify activity'), only: ['updateStatus']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $user = auth()->user();
            $activities = Activity::query()->with(['user'])->latest();

            if ($user->hasRole('Staff')) {
                $activities->where('user_id', $user->id);
            } elseif ($user->hasRole('Manager Operasional') || $user->hasRole('Manager Keuangan')) {
                $activities->whereHas('user', function ($query) use ($user) {
                    $query->where('supervisor_id', $user->id);
                });
            } elseif ($user->hasRole('Direktur')) {
                $managerIds = User::role(['Manager Operasional', 'Manager Keuangan'])->pluck('id');
                $activities->whereHas('user', function ($query) use ($managerIds) {
                    $query->whereIn('supervisor_id', $managerIds);
                });
            }

            return DataTables::of($activities->get())
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name ?? '-';
                })
                ->addColumn('activity', function ($row) {
                    return $row->name ?? '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->status() ?? '-';
                })
                ->addColumn('action', 'admin.activity.include.action')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.activity.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.activity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request)
    {
        try {
            $attr = $request->validated();

            if ($request->file('photo') && $request->file('photo')->isValid()) {

                $filename = $request->file('photo')->hashName();
                $request->file('photo')->storeAs('upload/kegiatan', $filename, 'public');

                $attr['photo'] = $filename;
            }

            Activity::create($attr);

            return redirect()->route('admin.activity.index')->with('success', 'Data berhasil Ditambah');
        } catch (\Throwable $th) {
            return redirect()->route('admin.activity.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return view('admin.activity.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('admin.activity.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        try {
            $attr = $request->validated();

            if ($request->file('photo') && $request->file('photo')->isValid()) {

                $path = storage_path('app/public/upload/kegiatan/');
                $filename = $request->file('photo')->hashName();
                $request->file('photo')->storeAs('upload/kegiatan', $filename, 'public');

                // delete old file from storage
                if ($activity->photo != null && file_exists($path . $activity->photo)) {
                    unlink($path . $activity->photo);
                }

                $attr['photo'] = $filename;
            }

            $activity->update($attr);

            return redirect()
                ->route('admin.activity.index')
                ->with('success', __('Data Berhasil Diubah'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.activity.index')
                ->with('error', __($th->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        try {
            if ($activity) {
                $photoPath = storage_path('app/public/upload/kegiatan/');

                if ($activity->photo != null && file_exists($photoPath . $activity->photo)) {
                    unlink($photoPath . $activity->photo);
                }

                $activity->delete();
            }

            return redirect()
                ->route('admin.activity.index')
                ->with('success', __('Data Berhasil Dihapus'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('admin.activity.index')
                ->with('error', __($th->getMessage()));
        }
    }

    public function updateStatus($activityId, $status)
    {
        $activity = Activity::findOrFail($activityId);

        // Validate the status value
        if (!in_array($status, [1, 2])) {
            return redirect()->route('admin.activity.index')->with('error', 'Invalid status.');
        }

        // Update the activity's status based on the action
        $activity->status = $status;
        $activity->save();  // Save the changes

        return redirect()->route('admin.activity.show', $activity->id)
            ->with('status', 'Data berhasil divalidasi');
    }
}
