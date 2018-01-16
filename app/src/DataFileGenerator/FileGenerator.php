<?php

namespace Phpsw\Website\DataFileGenerator;

abstract class FileGenerator
{
    /**
     * Use this function to obtain a slug for a given value (talk or event title, person's name etc).
     * The slugs are file names, and they're also used to link the data together.
     *
     * This function replaces any special characters with a hyphen,
     * replaces spaces with hyphens and lowercases the whole thing.
     *
     * @param string $value
     *
     * @return string
     */
    public function slugify(string $value): string
    {
        $value = strtolower(str_replace(' ', '-', $value));

        $chars = [',', '\'', '"', '$', '&', '_', ')', '(', '[', ']', '{', '}'];

        foreach ($chars as $char) {
            $value = str_replace($char, '-', $value);
        }

        return $value;
    }
}
