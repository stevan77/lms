<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
        ]);

        $file = $request->file('image');
        $image = imagecreatefromstring(file_get_contents($file->getRealPath()));

        if (!$image) {
            return response()->json(['error' => 'Invalid image'], 422);
        }

        $origWidth = imagesx($image);
        $origHeight = imagesy($image);
        $maxWidth = 1200;

        if ($origWidth > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) round($origHeight * ($maxWidth / $origWidth));
            $resized = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
            imagedestroy($image);
            $image = $resized;
        }

        $dir = public_path('images/lessons');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = Str::random(16) . '.webp';
        $path = $dir . '/' . $filename;

        imagewebp($image, $path, 82);
        imagedestroy($image);

        return response()->json([
            'url' => '/images/lessons/' . $filename,
        ]);
    }
}
