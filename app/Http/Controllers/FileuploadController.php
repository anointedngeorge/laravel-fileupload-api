<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileuploadRequest;
use App\Http\Requests\UpdateFileuploadRequest;
use App\Http\Resources\FileuploadResponse;
use App\Models\Fileupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileuploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FileuploadResponse::collection(Fileupload::paginate(100));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileuploadRequest $request)
    {
        try {
            $data = $request->validated();
            $file = $request->file('file');
            $path = $file->store('uploads', 's3');
            $url = Storage::disk('s3')->url($path);

            $upload = Fileupload::create([
                'file_path' => $url,
                'caption' => $data['caption'],
                'user_id' => Auth::id(),
            ]);

            return response()->json(['message' => 'File uploaded', 'data' => $upload], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred during file upload'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Fileupload $fileupload)
    {
        return response()->json($fileupload, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileuploadRequest $request, Fileupload $fileupload)
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('file')) {
                // remove old file
                $s3Path = str_replace(Storage::disk('s3')->url(''), '', $fileupload->file_path);
                Storage::disk('s3')->delete($s3Path);

                // Upload new file
                $file = $request->file('file');
                $path = $file->store('uploads', 's3');
                $data['file_path'] = Storage::disk('s3')->url($path);
            }

            $fileupload->update($data);
            return response()->json(['message' => 'File updated', 'data' => $fileupload], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'An error occurred during file update'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fileupload $fileupload)
    {
        try {

            $s3Path = str_replace(Storage::disk('s3')->url(''), '', $fileupload->file_path);
            Storage::disk('s3')->delete($s3Path);

            $fileupload->delete();
            return response()->json(['message' => 'File deleted'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'File deletion failed'], 500);
        }
    }
}
