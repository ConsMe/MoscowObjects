<?php

namespace App\Http\Controllers;

use App\EstateObject;
use Illuminate\Http\Request;
use App\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,manager')->except(['getdoc', 'checkIfObjectHasDocs']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:images,docs',
            'file' => 'required|file|max:20000',
        ]);
        $filepath = str_replace('app/', '', env('TMP_FILES_PATH'));
        $path = $request->file('file')->store($filepath);
        $pathToArray = explode('/', $path);
        $filename = $request->file->getClientOriginalName();
        $fields = [
            'original_filename' => $filename,
            'filename' => array_pop($pathToArray),
            'type' => $request->type,
        ];
        $file = File::create($fields);
        return $file;
    }

    public function destroy(Request $request, File $file)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);
        $filename = $request->filename;
        if ($file->filename !== $filename) {
            abort(422);
        }
        if (!$file->object_id) {
            $filepath = str_replace('app/', '', env('TMP_FILES_PATH'));
            Storage::delete($filepath.$filename);
        }
        $file->delete();
        return response(200);
    }

    public function getdoc(EstateObject $object)
    {
        if (Gate::denies('get-docs', $object)) {
            abort(403);
        }
        $object->load('docs');
        $docs = $object->docs;
        if (!$docs) {
            return redirect()->back();
        }
        $zip_file = 'docs.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        foreach ($docs as $doc) {
            $zip->addFile(storage_path('app/docs/'.$doc->filename), $doc->original_filename);
        }
        $zip->close();
        return response()->download($zip_file);
    }

    public function checkIfObjectHasDocs(EstateObject $object)
    {
        if (Gate::denies('get-docs', $object)) {
            abort(403);
        }
        $object->load('docs');
        \abort_if(!$object->docs->count(), 404);
        return \response(200);
    }
}
