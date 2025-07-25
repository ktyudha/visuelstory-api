<?php

namespace App\Http\Services\FileManager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FileManagerService
{

    public function __construct(public Request $request) {}

    function files($path = '', $recursive = false): array
    {
        $realPath = $this->getPath($path);

        $files = Storage::disk($this->getDisk())->files($realPath, $recursive);

        $userPath = $this->getUserPath();

        return array_map(function ($_item) use ($userPath) {
            return Str::replaceFirst($userPath, "", $_item);
        }, $files);
    }

    function directories($path = '', $recursive = false): array
    {
        $realPath = $this->getPath($path);

        $files = Storage::disk($this->getDisk())->directories($realPath, $recursive);


        return array_map(function ($_item) {
            return $this->clearPath($_item);
        }, $files);
    }

    function clearPath($path): string
    {
        $userPath = $this->getUserPath();
        $rawPathStr =  Str::replaceFirst($userPath, "", $path);

        return implode(
            DIRECTORY_SEPARATOR,
            array_filter(explode(DIRECTORY_SEPARATOR, $rawPathStr))
        );
    }

    function exists($path): bool
    {
        return Storage::disk($this->getDisk())->exists($this->getPath($path));
    }

    function isFile($path): bool
    {
        return Storage::disk($this->getDisk())->fileExists($this->getPath($path));
    }

    function directoryExists($path): bool
    {
        return Storage::disk($this->getDisk())->directoryExists($this->getPath($path));
    }

    function getUserPath($relativePath = null)
    {
        $root = config('filemanager.root');
        $userPath = "";

        if ($this->request->user()) {
            $userPath = $this->request->user()->id;
        }

        $rawPath = implode(DIRECTORY_SEPARATOR, array_filter([$root, $userPath, $relativePath]));

        $clearPath = implode(
            DIRECTORY_SEPARATOR,
            array_filter(explode(DIRECTORY_SEPARATOR, $rawPath))
        );

        return $clearPath;
    }

    function getPath($path = '')
    {
        if (Str::startsWith($path, "/..") || Str::startsWith($path, "..") || Str::contains($path, "../")) {
            throw ValidationException::withMessages([
                'path' => 'Invalid path.'
            ]);
        }

        return implode(DIRECTORY_SEPARATOR, [$this->getUserPath(), $path]);
    }

    function getDisk()
    {
        return config('filemanager.disk', config('filesystems.default'));
    }

    /**
     * Default 96MB
     */
    function getMaxUploadSize()
    {
        return config('filemanager.max_upload', 96 * 1024);
    }

    function getAllowedMimeTypes()
    {
        return config('filemanager.allowed_mime_types');
    }
}
