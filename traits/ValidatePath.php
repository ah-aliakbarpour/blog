<?php

namespace app\traits;

trait ValidatePath
{
    public function validatePath(string $path): string
    {
        // If path ends with /, remove / from end
        if ($path[-1] ?? null === '/')
            $path = substr($path, 0, -1);

        // If path does not start with /, add / to start
        if ($path[0] ?? null !== '/')
            $path = '/' . $path;

        return $path;
    }
}