<?php

namespace yframe\request;

define("APP_PATH", $_SERVER['DOCUMENT_ROOT']);
class View
{

    public static function temp($path, $data)
    {
        try {
            $path = explode('/', $path);
            $app = $path[0];
            $controller = $path[1];
            $action = $path[2];
            $file = APP_PATH . '/view/'.$app.'/' . $controller . '/' . $action . '.html';
            if (file_exists($file)) {
                $content = file_get_contents($file);
                $content = self::replace($content, $data);
                echo $content;exit();
            } else {
                throw new \Exception('模板不存在');
            }
        }
        catch (\Exception $e){
            return $e->getMessage();
        }

    }

    private static function replace($content, $data)
    {

        $content = self::foreachReplace($content, $data);

        $pattern = '/\{\$([a-zA-Z_][a-zA-Z0-9_]*)\}/';
        $content = preg_replace_callback($pattern, function ($matches) use ($data) {
            if (isset($data[$matches[1]])) {
                return $data[$matches[1]];
            } else {
                return '';
            }
        }, $content);
        return $content;
    }

    private static function foreachReplace($content, $data)
    {
        $pattern = '/\{foreach\s+\$([a-zA-Z_][a-zA-Z0-9_]*)\s+as\s+\$([a-zA-Z_][a-zA-Z0-9_]*)\s*(=>\s*\$([a-zA-Z_][a-zA-Z0-9_]*))?\s*\}(.*?)\{\/foreach\}/is';
        $content = preg_replace_callback($pattern, function ($matches) use ($data) {
            $str = '';

            if (isset($data[$matches[1]]) && is_array($data[$matches[1]])) {
                foreach ($data[$matches[1]] as $key => $value) {

                    $loopData = [$matches[4] => $value];
                    if (isset($matches[2])) {
                        $loopData[$matches[2]] = $key;
                    }

                    $str .= trim(self::replace($matches[5], $loopData));
                }
            }
            return $str;
        }, $content);
        return $content;
    }












}