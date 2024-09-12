<?php

namespace paulmillband\cachedImageResizer\App\Models\Helper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ImageFormats extends Model
{
    public static function getImageFormatFromExtension($extension){
        switch ($extension){
            case 'jpg':
            case 'jpeg':
                return 'JPEG';
                break;
        }
        return strtoupper($extension);
    }
}
