<?php

declare(strict_types=1);

namespace App\Modules\Servers\Application\Services;

use InvalidArgumentException;
use RuntimeException;

final readonly class ServerStorage
{
    public function __construct(
        private string $storageDir,
    ) {
    }

    public function uploadBase64(string $filename, string $base64): string
    {
        $safeFilename = $this->sanitizeFilename($filename);
        $path = rtrim($this->storageDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $safeFilename;

        if (!is_dir($this->storageDir)) {
            if (!@mkdir($concurrentDirectory = $this->storageDir, 0775, true) && !is_dir($concurrentDirectory)) {
                throw new RuntimeException(sprintf('Failed to create directory: %s', $this->storageDir));
            }
        }

        $payload = $base64;
        $commaPos = strpos($payload, ',');

        if ($commaPos !== false && str_starts_with($payload, 'data:')) {
            $payload = substr($payload, $commaPos + 1);
        }

        $binary = base64_decode($payload, true);

        if ($binary === false) {
            throw new InvalidArgumentException('Invalid base64 payload provided.');
        }

        $bytes = @file_put_contents($path, $binary, LOCK_EX);

        if ($bytes === false) {
            throw new RuntimeException(sprintf('Failed to write file: %s', $path));
        }

        return $safeFilename;
    }

    private function sanitizeFilename(string $filename): string
    {
        $filename = preg_replace('~[\\\\/]+~', '_', $filename) ?? $filename;
        $filename = preg_replace('~[^A-Za-z0-9._-]~', '_', $filename) ?? $filename;

        if ($filename === '' || $filename === '.' || $filename === '..') {
            throw new InvalidArgumentException('Invalid filename.');
        }

        return $filename;
    }
}