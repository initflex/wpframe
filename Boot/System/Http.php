<?php

namespace WPFP\Boot\System;

// FOR CLEAN URL
class Http
{
    /**
     * Cleaner URLs
     *
     * @param	string  $url
     * @param   string  $regexCleaner
     * @return	void	Return is String or Void data.
     */
    public function cleaner($url = null, $regexCleaner = null)
    {
        if ($url !== null && $regexCleaner !== null) {
            $clean_url = preg_replace($regexCleaner, '', strtolower($url));
            return $clean_url;
        } else {
            return null;
        }
    }
}
