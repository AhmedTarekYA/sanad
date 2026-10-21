<?php

use App\Helpers\ConstantHelper;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

/**
 * @param  $image
 * @param  $path
 * @param  $compress
 * @param  $quality_ratio
 * @return string
 */
if (! function_exists('uploadFile')) {
    function uploadFile($image, $path, $compress = null, $quality_ratio = 90)
    {
        // Generate a random file name
        $fileName = getRandomStringRandomInt(10).time();
        // Create the destination path if it doesn't exist
        $destinationPath = storage_path('app/public/'.$path);
        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'webp', 'tiff', 'eps'];  // Add other allowed extensions
        try {
            // Compress the image if needed
            if (in_array($image->extension(), $allowedExtensions)) {
                $fileName .= '.webp';
                $configuredDriver = config('image.driver', 'gd');
                $driver = $configuredDriver === 'gd' ? GdDriver::class : $configuredDriver;
                $manager = new ImageManager($driver);
                $img = $manager->decodeSplFileInfo($image);
                $img->encode(new WebpEncoder($quality_ratio))->save($destinationPath.'/'.$fileName);

                return $path.$fileName;

            } else {
                if (substr($path, -1) === '/') {
                    $path = rtrim($path, '/');
                }

                return $image->store($path, 'public');
            }

        } catch (Exception $e) {
            // For now, continue with the original image without compression
            $fileName .= '.'.$image->extension();
            $image->move($destinationPath, $fileName);

            return $path.$fileName;
        }
    }
}

/**
 * @param  $fileFullPath
 * @return mixed
 */
if (! function_exists('deleteFile')) {
    function deleteFile($fileFullPath)
    {
        $deletePath = storage_path('');
        $deletePath .= ConstantHelper::filesPath;
        $deletePath .= $fileFullPath;

        return File::delete($deletePath);
    }
}

/**
 * @param  $fileFullPath
 * @return string
 */
if (! function_exists('showFile')) {
    function showFile($fileFullPath, string $type = 'image'): string
    {
        $defaults = [
            'admin' => '/default/admin.webp',
            'image' => '/default/no_image.png',
        ];

        $default = asset($defaults[$type] ?? $defaults['image']);

        if (empty($fileFullPath)) {
            return $default;
        }

        if (file_exists(public_path('/storage/'.$fileFullPath))) {
            return asset('/storage/'.$fileFullPath);
        }

        return $default;
    }
}

/**
 * @param  $fileFullPath
 * @param  $width
 * @param  $height
 * @return string
 */
if (! function_exists('getImgTag')) {
    function getImgTag($fileFullPath, $width = '150px', $height = '120px')
    {
        $image_path = showFile($fileFullPath);
        if (file_exists('storage/'.$fileFullPath)) {
            $file_extension = strtolower(pathinfo($fileFullPath, PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
            if (in_array($file_extension, $allowed_extensions)) {
                // If it's an image, generate img tag
                return '<a data-fancybox="images" href="'.$image_path.'"><img src="'.$image_path.'" alt="profile-image" style="height: '.$height.'; width: '.$width.';" class="avatar rounded me-2"></a>';
            }
            // If not an image, generate download link with file name
            $file_name = basename($fileFullPath);

            return '<a href="'.$image_path.'" download="'.$file_name.'"><i class="fas fa-download"></i> '.$file_name.'</a>';
        }

        return '<a data-fancybox="images" href="'.$image_path.'"><img src="'.$image_path.'" alt="profile-image" style="height: '.$height.'; width: '.$width.';" class="avatar rounded me-2"></a>';
    }
}
