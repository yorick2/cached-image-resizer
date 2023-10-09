<?php


namespace paulmillband\cachedImageResizer\App\Models;

class Image
{
    protected string $filePath;
    protected string $url;
    protected array $accessibleProtectedVariables = [
            'filePath',
            'url'
    ];

    /**
     * Image constructor.
     * @param string $filePath
     * @throws \Exception
     */
    public function __construct(string $filePath)
    {
            $this->setFilePath($filePath);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __set(string $name, $value)
    {
        if (!in_array($name,$this->accessibleProtectedVariables)){
            throw new \Exception("access to variable '${name}' denied");
        }
        $functionName = 'set'.ucfirst($name);
        if(is_callable(array($this, $functionName))){
            $this->$functionName($value);
            return;
        }
        $this->$name = $value;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get(string $name)
    {
        if (!in_array($name,$this->accessibleProtectedVariables)){
            throw new \Exception("access to variable '${name}' denied");
        }
        $functionName = 'get'.ucfirst($name);
        if(is_callable(array($this, $functionName))){
            return $this->$functionName();
        }
        return $this->$name;
    }

    /**
     * @param string $imageFilePath
     * @throws \Exception
     */
    public function setFilePath(string $imageFilePath)
    {
        if(!file_exists($imageFilePath)){
            throw new \Exception('file not found');
        }
        switch (exif_imagetype($imageFilePath)){
            case IMAGETYPE_JPEG:
                break;
            case IMAGETYPE_PNG:
            case IMAGETYPE_GIF:
            case IMAGETYPE_WEBP:
                throw new \Exception('file not an allowed file type');
                break;
            default:
                throw new \Exception('file not an allowed file type');
        }
        $this->filePath = $imageFilePath;
    }

    /**
     * @return string
     */
    public function getImageType(){
        return image_type_to_mime_type(exif_imagetype($this->filePath));
    }

    /**
     * @return string
     */
    public function getUrl(){
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $protocol = "https://";
        }else{
            $protocol = "http://";
        }
        return $protocol.$_SERVER['HTTP_HOST']
            .str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath($this->filePath));
    }
}
