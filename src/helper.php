<?php

use Illuminate\Support\Facades\File;

if (! function_exists('upload_file')) {
    function upload_file($file_path, $file_field, $data){
        $imgPath = now()->timespan() . '.' . request()->file->extension();
        request()->img->move(public_path($file_path), $imgPath);
        $data->update([
           $file_field  => $file_path . '/' . $imgPath,
        ]);
    }
}

if (! function_exists('save_file')) {
    function save_file($file_path, $file, $current = null){
        if ($current != null) {
            File::delete(public_path($current));
        }

        $imgPath = now() . ' | ' . $file->getClientOriginalName();
        $file->move(public_path($file_path), $imgPath);

        return $file_path . $imgPath;
    }
}