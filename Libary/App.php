<?php

class App
{
    public static function getBaseURL()
    {
        return "https://homepageleppe.ddev.site/";
//        return "https://taekwondo-allkampf-leppersdorf.de/";
    }

    public static function normalize_Postfiles_array(array $files): array
    {
        $normalized_array = [];
        foreach($files as $index => $file) {

            if (!is_array($file['name'])) {
                $normalized_array[$index][] = $file;
                continue;
            }

            foreach($file['name'] as $idx => $name) {
                $normalized_array[$index][$idx] = [
                    'name' => $name,
                    'type' => $file['type'][$idx],
                    'tmp_name' => $file['tmp_name'][$idx],
                    'error' => $file['error'][$idx],
                    'size' => $file['size'][$idx]
                ];
            }
        }
        return $normalized_array;
    }
}