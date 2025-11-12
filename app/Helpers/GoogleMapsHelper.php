<?php

namespace App\Helpers;

class GoogleMapsHelper
{
    /**
     * Convert berbagai format link Google Maps menjadi embed URL
     * 
     * @param string $url Link Google Maps dari user
     * @return string URL yang siap di-embed
     */
    public static function convertToEmbed($url)
    {
        if (empty($url)) {
            return null;
        }

        // Jika sudah format embed, return langsung
        if (strpos($url, 'google.com/maps/embed') !== false) {
            return $url;
        }

        // Jika link dipersingkat (goo.gl atau maps.app.goo.gl), expand dulu
        if (strpos($url, 'goo.gl') !== false || strpos($url, 'maps.app.goo.gl') !== false) {
            $expandedUrl = self::expandShortUrl($url);
            if ($expandedUrl) {
                $url = $expandedUrl;
            }
        }

        // Extract koordinat dari berbagai format URL
        $patterns = [
            '/@(-?\d+\.\d+),(-?\d+\.\d+)/',  // Format: @lat,lng
            '/q=(-?\d+\.\d+),(-?\d+\.\d+)/',  // Format: q=lat,lng
            '/place\/[^\/]+\/@(-?\d+\.\d+),(-?\d+\.\d+)/', // Format place/@lat,lng
            '/ll=(-?\d+\.\d+),(-?\d+\.\d+)/', // Format: ll=lat,lng
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                $lat = $matches[1];
                $lng = $matches[2];
                return "https://www.google.com/maps?q={$lat},{$lng}&output=embed";
            }
        }

        // Fallback: coba parse dari URL parameter
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        if (isset($params['q'])) {
            return "https://www.google.com/maps?q=" . urlencode($params['q']) . "&output=embed";
        }

        // Fallback terakhir: coba embed langsung dengan modifikasi URL
        $embedUrl = str_replace(['/maps/place/', '/maps/'], ['/maps/embed/v1/place?key=&q=', '/maps/embed?pb='], $url);
        
        return $embedUrl;
    }

    /**
     * Expand shortened URL (goo.gl) menjadi full URL
     * 
     * @param string $shortUrl
     * @return string|null
     */
    private static function expandShortUrl($shortUrl)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $shortUrl);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            curl_exec($ch);
            $expandedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            curl_close($ch);
            
            return $expandedUrl ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Extract koordinat latitude dan longitude dari URL Google Maps
     * 
     * @param string $url
     * @return array|null ['lat' => float, 'lng' => float]
     */
    public static function extractCoordinates($url)
    {
        if (empty($url)) {
            return null;
        }

        // Expand short URL jika perlu
        if (strpos($url, 'goo.gl') !== false || strpos($url, 'maps.app.goo.gl') !== false) {
            $expandedUrl = self::expandShortUrl($url);
            if ($expandedUrl) {
                $url = $expandedUrl;
            }
        }

        // Extract koordinat
        $patterns = [
            '/@(-?\d+\.\d+),(-?\d+\.\d+)/',
            '/q=(-?\d+\.\d+),(-?\d+\.\d+)/',
            '/place\/[^\/]+\/@(-?\d+\.\d+),(-?\d+\.\d+)/',
            '/ll=(-?\d+\.\d+),(-?\d+\.\d+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return [
                    'lat' => (float) $matches[1],
                    'lng' => (float) $matches[2],
                ];
            }
        }

        return null;
    }

    /**
     * Validasi apakah URL adalah Google Maps yang valid
     * 
     * @param string $url
     * @return bool
     */
    public static function isValidGoogleMapsUrl($url)
    {
        if (empty($url)) {
            return false;
        }

        $validDomains = [
            'maps.google.com',
            'www.google.com/maps',
            'google.com/maps',
            'goo.gl/maps',
            'maps.app.goo.gl',
        ];

        foreach ($validDomains as $domain) {
            if (strpos($url, $domain) !== false) {
                return true;
            }
        }

        return false;
    }
}