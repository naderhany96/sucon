<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Media;

trait Uploader {

    public function uploads($entity, $file, $folder, $attr, $disk = 'public')
    {
        if($file) {

            $file_original_name = preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file_name = $entity->id .'-'. time() .'-'. $file_original_name;
            $file_type = $file->getClientOriginalExtension();
            $file_path = "$folder/$file_name";

            Storage::disk($disk)->put($file_path, File::get($file));

            $media = Media::create([
                'mediable_id' => $entity->id,
                'mediable_type' => get_class($entity),
                'attribute' => $attr,
                'name' => "$file_name",
                'type' => $file_type,
                'path' => $file_path,
                'size' => $this->fileSize($file),
            ]);

            return $media->path;
        }
    }

    public function deleteIfExist($property, $keyName)
    {
        $mediaFiles = $property->media()->where('attribute', $keyName)->get();
        
        if ($mediaFiles && $mediaFiles->count() > 0) 
            foreach ($mediaFiles as $mediaFile) 
                $mediaFile->delete();
    }

    public function fileSize($file, $precision = 2)
    {   
        $size = $file->getSize();

        if ( $size > 0 ) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }

        return $size;
    }
}