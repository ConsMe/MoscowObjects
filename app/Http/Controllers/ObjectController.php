<?php

namespace App\Http\Controllers;

use App\EstateObject;
use Illuminate\Http\Request;
use App\Http\Requests\StoreObjectRequest;
use App\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\Gate;

class ObjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin,manager')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $objects = EstateObject::select(['id', 'characteristics', 'updated_at', 'only_auth', 'price_admins_only']);
        if ($user && $user->isAdminGroup()) {
            $objects->addSelect('responsible');
        } else {
            $objects->where('object_admins_only', false);
        }
        $objects = $objects->with(['images' => function ($query) {
            $query->select(['id', 'filename', 'isMain', 'type', 'object_id', 'caption'])->orderBy('isMain', 'DESC');
        }, 'docs' => function ($query) {
            $query->select(['id', 'object_id']);
        }])->get();
        foreach ($objects as $object) {
            if (Gate::denies('see-price', $object)) {
                $characteristics = $object->characteristics;
                $characteristics['cost'] = '';
                $object->characteristics = $characteristics;
            }
        }
        return $objects;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreObjectRequest $request)
    {
        $object = new EstateObject;
        $this->saveObject($object, $request);
        return $object->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EstateObject  $estateObject
     * @return \Illuminate\Http\Response
     */
    public function show(EstateObject $object)
    {
        if (Gate::allows('see-description', $object)) {
            return $object->description;
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EstateObject  $estateObject
     * @return \Illuminate\Http\Response
     */
    public function edit(EstateObject $object)
    {
        $object->load(['images', 'docs']);
        $fields = ['characteristics', 'description', 'responsible', 'images', 'docs', 'only_auth', 'price_admins_only', 'object_admins_only'];
        return $object->only($fields);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EstateObject  $estateObject
     * @return \Illuminate\Http\Response
     */
    public function update(StoreObjectRequest $request, EstateObject $object)
    {
        return $this->saveObject($object, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EstateObject  $estateObject
     * @return \Illuminate\Http\Response
     */
    public function destroy(EstateObject $object)
    {
        $object->load(['images', 'docs', 'favourites']);
        foreach ($object->images as $image) {
            $filepath = str_replace('app/', '', env('SMALL_IMAGES_PATH'));
            Storage::delete($filepath.$image->filename);
            $filepath = str_replace('app/', '', env('BIG_IMAGES_PATH'));
            Storage::delete($filepath.$image->filename);
            $image->delete();
        }
        foreach ($object->docs as $doc) {
            Storage::delete('docs/'.$doc->filename);
            $doc->delete();
        }
        $object->favourites()->delete();
        $object->delete();
        return response(200);
    }

    public function saveObject($object, $request)
    {
        $newImagesData = ['images' => [], 'docs' => []];
        $filesIds = collect($request->images)->concat(collect($request->docs))->pluck('id');
        $files = File::whereIn('id', $filesIds)->get();
        foreach ($request->images as $id => $image) {
            $file = $files->where('filename', $image['filename'])->first();
            if (!$file) continue;
            $update = [
                'caption' => $image['caption'],
                'isMain' => $image['isMain'],
            ];
            if (!isset($image['object_id'])) {
                $originalImage = Image::make(storage_path(env('TMP_FILES_PATH').$file->filename));
                $big = $originalImage->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $newFilename = Str::random(40).'.jpg';
                $big->save(storage_path(env('BIG_IMAGES_PATH').$newFilename));
                $small = $originalImage->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $small->save(storage_path(env('SMALL_IMAGES_PATH').$newFilename));
                $filepath = str_replace('app/', '', env('TMP_FILES_PATH'));
                Storage::delete($filepath.$file->filename);
                $update['filename'] = $newFilename;
                $newImagesData['images'][$id] = [
                    'filename' => $newFilename,
                ];
            }
            if (isset($update['filename']) || $file->caption !== $update['caption'] || $file->isMain !== $update['isMain']) {
                $file->update($update);
            }
        }
        foreach ($request->docs as $id => $doc) {
            $file = $files->where('filename', $doc['filename'])->first();
            if ($file && !isset($doc['object_id'])) {
                $filepath = str_replace('app/', '', env('TMP_FILES_PATH'));
                Storage::move($filepath.$file->filename, 'docs/'.$file->filename);
                $newImagesData['docs'][$id] = [];
            }
        }
        $object->fill($request->only([
            'responsible', 'description', 'only_auth', 'price_admins_only', 'object_admins_only',
        ]));
        $object->characteristics = $request->except([
            'responsible', 'description', 'images', 'docs', 'only_auth', 'price_admins_only', 'object_admins_only',
        ]);
        $object->save();
        foreach ($newImagesData as &$type) {
            foreach ($type as &$data) {
                $data['object_id'] = $object->id;
            }
        }
        File::whereIn('id', $filesIds)->update(['object_id' => $object->id]);
        $filesForRemoving = File::whereNotIn('id', $filesIds)->where(['object_id' => $object->id]);
        foreach ($filesForRemoving->get() as $file) {
            if ($file->type === 'images') {
                $filepath = str_replace('app/', '', env('BIG_IMAGES_PATH'));
                Storage::delete($filepath.$file->filename);
                $filepath = str_replace('app/', '', env('SMALL_IMAGES_PATH'));
                Storage::delete($filepath.$file->filename);
            } elseif ($file->type === 'docs') {
                Storage::delete('docs/'.$file->filename);
            }
        }
        $filesForRemoving->delete();
        return $newImagesData;
    }

}
