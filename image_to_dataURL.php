<?php
// overengineered for OOP practice

abstract class ImageConverter
{
    protected string $imagePath;
    protected $allowedTypes = [];

    public function __construct(string $imagePath = "", $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'])
    {
        $this->imagePath = $imagePath;
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath(string $imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @param array|mixed|string[] $allowedTypes
     */
    public function setAllowedTypes($allowedTypes): void
    {
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * @return array|mixed|string[]
     */
    public function getAllowedTypes()
    {
        return $this->allowedTypes;
    }

    abstract function build();
}

// just to have a quick test
class Image2NameConverter extends ImageConverter
{
    public function build()
    {
        $imageName = explode(DIRECTORY_SEPARATOR, $this->imagePath);
        $imageName = $imageName[count($imageName) - 1];
        $imageName = explode(".", $imageName)[0];
        $imageName = ucfirst($imageName);

        return $imageName;
    }
}

abstract class Image2UriConverter extends ImageConverter
{
    private const URI_TEMPLATE = "data:%s;base64,%s";

    final protected function toUri()
    {
        $file = new SplFileObject($this->imagePath);
        $imageInfo = getimagesize($file->getRealPath());
        ['mime' => $mimeType] = $imageInfo;

        if (!in_array($mimeType, $this->allowedTypes)) {
            throw new \InvalidArgumentException($file->getFilename() . " not of type " . implode(", ", $this->allowedTypes));
        }

        $file = $file->openFile('r');
        $b64 = base64_encode($file->fread($file->getSize()));
        $b64 = sprintf(self::URI_TEMPLATE, $mimeType, $b64);
        return ['name' => $file->getFilename(), 'b64' => $b64, 'info' => $imageInfo];
    }

    abstract function build();
}

class Image2UriImageTagConverter extends Image2UriConverter
{
    public function build()
    {
        $uri = $this->toUri();
        $b64 = $uri['b64'];
        $htmlSizeStr = $uri['b64'][3];
        return sprintf('<img %s src="%s">', $htmlSizeStr, $b64);
    }
}

class Image2UriSeperatedString extends Image2UriConverter
{
    private const B64SEPARATOR = '++++++++++++++++++';

    public function build()
    {
        $uri = $this->toUri();
        $b64 = $uri['b64'];
        $name = $uri['name'];
        return sprintf("%s%s%s%s%s%s", $name, PHP_EOL, self::B64SEPARATOR, PHP_EOL, $b64, PHP_EOL . PHP_EOL);
    }
}

class BatchConverter
{
    private array $imagePaths;
    private ImageConverter $converter;

    public function __construct(array $images = [], ImageConverter $converter)
    {
        $this->imagePaths = $images;
        $this->converter = $converter;
    }

    public function buildAll(): array
    {
        $converted = []; // not type
        foreach ($this->imagePaths as $image) {
            $this->converter->setImagePath($image);
            $converted[] = $this->converter->build();
        }
        return $converted;
    }
}

$images = new FilesystemIterator(__DIR__ . '/files', FilesystemIterator::SKIP_DOTS | FilesystemIterator::UNIX_PATHS);
$images = new RegexIterator($images, "/.+?\.(?:jpg|gif|png)/i");
$images = iterator_to_array($images);

//$converter = new BatchConverter($images, new Image2NameConverter());
$converter = new BatchConverter($images, new Image2UriImageTagConverter());
$imgTagImages = $converter->buildAll();

foreach ($imgTagImages as $image) {
    echo $image;
}

$converter = new BatchConverter($images, new Image2UriSeperatedString());
$b64stringImages = $converter->buildAll();
echo '<pre>';
foreach ($b64stringImages as $image) {
    echo $image;
}
echo '</pre>';
