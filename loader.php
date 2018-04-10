<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);

spl_autoload_register (function ($class)
        {
            $arr = explode('\\', $class);
            switch ($arr[0])
            {
                case 'View': {$pre = 'src/'; break;}
                case 'Control': {$pre = 'src/'; break;}
                case 'Model': {$pre = 'src/'; break;}
                case 'Tec': {$pre = ''; break;}
                case 'Conf': {$pre = ''; break;}
                default: $pre = '';
            }
            $path = __DIR__ . '/' .$pre. str_replace('\\', '/', $class) . '.php';

            if (is_file($path))
            {
                require $path;
                return;
            }
            throw new \LogicException(sprintf('Class "%s" not found in "%s"', $class, $path));
        });
