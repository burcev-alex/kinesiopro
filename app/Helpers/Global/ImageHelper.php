<?php

if (!function_exists('isSupportWebP')) {
    /**
     * Поддержка формата WebP.
     *
     * @return boolean
     */
    function isSupportWebP()
    {
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            $agent = $_SERVER['HTTP_USER_AGENT'];
            preg_match("/(MSIE|Opera|Firefox|Chrome|Version)(?:\/| )([0-9.]+)/", $agent, $bInfo);
            if (is_array($bInfo) && count($bInfo) > 0) {
                $browserInfo = [];
                $browserInfo['name'] = ($bInfo[1] == "Version") ? "Safari" : $bInfo[1];
                $browserInfo['version'] = $bInfo[2];

                $expVersion = explode(".", $browserInfo['version']);

                if ($browserInfo['name'] != 'Safari') {
                    $result = true;
                } elseif ($browserInfo['name'] == 'Safari' && intval($expVersion[0]) >= 14) {
                    $result = true;
                } else {
                    $result = false;
                }
            } else {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }
}

if (!function_exists('imageCreatePath')) {
    function imageCreatePath($path)
    {
        if (is_dir($path)) {
            return true;
        }
        $prev_path = substr($path, 0, strrpos($path, '/', -2) + 1);
        $return = imageCreatePath($prev_path);
        return ($return && is_writable($prev_path)) ? mkdir($path, 0755, true) : false;
    }
}

if (!function_exists('convertImageToWebP')) {
    function convertImageToWebP($source, $quality = 80)
    {
        if (substr_count($source, public_path()) == 0) {
            $source = public_path().$source;
        }

        if (!file_exists($source)) {
            return $source;
        }

        // определить наличие пробелов или карилицы в урл,
        // при наличии провести экранирование
        $exp = explode('/', $source);
        $exp[count($exp) - 1] = urlencode($exp[count($exp) - 1]);
        $source = implode('/', $exp);

        try {
            $extension = pathinfo($source, PATHINFO_EXTENSION);
            $destination = str_replace(["/storage/", ".".$extension], ["/storage/webp/", ".webp"], $source);

            if (!file_exists($destination)) {
                if ($extension == 'jpeg' || $extension == 'jpg') {
                    $image = imagecreatefromjpeg($source);
                } elseif ($extension == 'gif') {
                    $image = imagecreatefromgif($source);
                } elseif ($extension == 'png') {
                    $image = imagecreatefrompng($source);
                } else {
                    $image = imagecreatefromjpeg($source);
                }

                $destination = str_replace(["/storage/", ".".$extension], ["/storage/webp/", ".webp"], $source);
                $exp = explode("/", $destination);
                unset($exp[count($exp) - 1]);
                $pathDir = implode("/", $exp);
                imageCreatePath($pathDir);

                imagewebp($image, $destination, $quality);
            }

            $destination = str_replace(public_path(), "", $destination);

            return $destination;
        } catch (\Exception $e) {
            $source = str_replace(public_path(), "", $source);
            return $source;
        }
    }
}
