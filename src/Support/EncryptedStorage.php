<?php

namespace Joebatta\Reuse\Support;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class EncryptedStorage
{
    public static function disk(string $disk): self
    {
        return new EncryptedStorage($disk);
    }

    private string $disk;

    public function __construct(string $disk)
    {
        $this->disk = $disk;
    }

    public function put(string $path, $contents, mixed $options = []): bool
    {
        $encryptedContents = Crypt::encrypt($contents);
        return Storage::disk($this->disk)->put($path, $encryptedContents, $options);
    }

    public function delete(string|array $paths): bool
    {
        return Storage::disk($this->disk)->delete($paths);
    }

    public function get(string $path)
    {
        $contents = Storage::disk($this->disk)->get($path);
        return Crypt::decrypt($contents);
    }
}
