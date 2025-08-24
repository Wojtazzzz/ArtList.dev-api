<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Services;

final readonly class ServerStorage
{
    public function uploadBase64(string $filename, string $base64): string
    {
        $path = __DIR__ . '/../../../../../public/servers/' . $filename;

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        file_put_contents($path, base64_decode($base64));

        return $filename;
    }
}