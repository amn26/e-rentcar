<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageValidator
{
    public static function validate(UploadedFile $file): array
    {
        $errors = [];
        
        // Check extension
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!in_array($extension, $allowedExtensions)) {
            $errors[] = 'File must be an image (jpg, jpeg, png, gif, webp)';
        }
        
        // Check size (2MB)
        if ($file->getSize() > 2048000) {
            $errors[] = 'Image size must not exceed 2MB';
        }
        
        // Check if it's actually an image using getimagesize
        $imageInfo = @getimagesize($file->getRealPath());
        if ($imageInfo === false) {
            $errors[] = 'File is not a valid image';
        }
        
        return $errors;
    }
    
    public static function store(UploadedFile $file, string $folder = 'cars'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(40) . '.' . $extension;
        $path = $folder . '/' . $filename;
        
        // Move file manually without MIME detection
        $file->move(storage_path('app/public/' . $folder), $filename);
        
        return $path;
    }
}
