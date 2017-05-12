<?php

namespace Yakuzan\Helpers;

class Cookie
{
	public static function exists($name)
	{
		if(is_array($name)) {
			$output = [];

			foreach($name as $item) {
				$output[(string)$item] = isset($_COOKIE[(string) $item]);
			}

			return $output;
		}

		return isset($_COOKIE[(string)$name]);
	}

	public static function get($name)
  {
        if (is_array($name)) {
            $output = [];
            foreach ($name as $item) {
                $output[ (string)$item ] = self::exists($item) ? $_COOKIE[ (string)$item ] : null;
            }

            return $output;
        }

        return self::exists($name) ? $_COOKIE[ (string)$name ] : null;
    }
}
