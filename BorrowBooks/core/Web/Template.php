<?php

namespace Core\Web;

class Template
{
    private static array  $blocks        = array();
    private static string $cache_path    = '';
    private static bool   $cache_enabled = false;

    public static function configure(
        ?string $cache_path = null,
        ?bool   $cache_enabled = null
    ): void
    {
        if (!is_null($cache_path)) {
            static::$cache_path = $cache_path;
        }

        if (!is_null($cache_enabled)) {
            static::$cache_enabled = $cache_enabled;
        }
    }

    public static function render(string $filename, array $data = []): string
    {
        ob_start();

        self::view(DIR_ROOT . "/$filename", $data);

        return ob_get_clean();
    }

    static function view(string $filename, array $data = []): void
    {
        $cached_filename = self::cache($filename);

        extract($data, EXTR_SKIP);

        require $cached_filename;
    }

    public static function cache($file): string
    {
        $file = str_replace(DIR_ROOT, '', $file);
        if (str_starts_with($file, '/')) {
            $file = substr($file, 1);
        }

        if (self::$cache_path and !file_exists(self::$cache_path)) {
            mkdir(self::$cache_path, recursive: true);
        }

        if (!str_ends_with(self::$cache_path, '/')) {
            self::$cache_path .= '/';
        }

        $cached_filename = self::$cache_path . str_replace(array('/', '.html'), array('_', ''), $file . '.php');

        if (!self::$cache_enabled || (!file_exists($cached_filename) ||
                (filemtime($cached_filename) < filemtime(DIR_ROOT . "/$file")))
        ) {
            $code = self::includeFiles(DIR_ROOT . "/$file");
            $code = self::compileCode($code);

            file_put_contents($cached_filename,
                '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code
            );
        }

        return $cached_filename;
    }

    public static function clearCache(): void
    {
        foreach (glob(self::$cache_path . '*') as $file) {
            unlink($file);
        }
    }

    public static function compileCode($code): string
    {
        $code = self::compileBlock($code);
        $code = self::compileYield($code);
        $code = self::compileEscapedEchos($code);
        $code = self::compileEchos($code);

        return self::compilePHP($code);
    }

    static function includeFiles($file): array|string|null
    {
        $code = file_get_contents($file);

        preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $value) {
            $filename = DIR_ROOT . '/' . $value[2];
            $code     = str_replace($value[0], self::includeFiles($filename), $code);
        }

        return preg_replace('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', '', $code);
    }

    static function compilePHP($code): array|string|null
    {
        return preg_replace('~\{%\s*(.+?)\s*\%}~is', '<?php $1 ?>', $code);
    }

    static function compileEchos($code): array|string|null
    {
        return preg_replace('~\{{\s*(.+?)\s*\}}~is', '<?php echo $1 ?>', $code);
    }

    static function compileEscapedEchos($code): array|string|null
    {
        return preg_replace('~\{{{\s*(.+?)\s*\}}}~is', '<?php echo htmlentities($1, ENT_QUOTES, \'UTF-8\') ?>', $code);
    }

    static function compileBlock($code): mixed
    {
        preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $value) {
            if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';

            if (!str_contains($value[2], '@parent')) {
                self::$blocks[$value[1]] = $value[2];
            } else {
                self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
            }

            $code = str_replace($value[0], '', $code);
        }

        return $code;
    }

    static function compileYield($code): array|string|null
    {
        foreach (self::$blocks as $block => $value) {
            $code = preg_replace('/{% ?yield ?' . $block . ' ?%}/', $value, $code);
        }

        return preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $code);
    }

}
