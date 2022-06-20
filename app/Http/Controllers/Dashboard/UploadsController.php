<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class UploadsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store()
    {
        $payload = request()->file();

        if (! $payload) {
            return response()->json(null, 400);
        }

        // Only grab the first element because single file uploads
        // are not supported at this time
        $file = reset($payload);

        $path = $file->storePublicly(dashboardStoragePath(), [
            'disk' => config('dashboard.storage_disk'),
        ]);

        return Storage::disk(config('dashboard.storage_disk'))->url($path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        if (empty(request()->getContent())) {
            return response()->json(null, 400);
        }

        $file = pathinfo(request()->getContent());

        $storagePath = dashboardStoragePath();

        $path = "{$storagePath}/{$file['basename']}";

        Storage::disk(config('dashboard.storage_disk'))->delete($path);

        return response()->json([], 204);
    }
}
