<?php


use App\Models\User;
use Illuminate\Support\Str;

/**
 * Return a list of available language codes.
 *
 * @return array
 */
    function availableLanguageCodes(): array
    {
        $locales = preg_grep('/^([^.])/', scandir(dirname(__DIR__, 1).'/resources/lang'));

        return collect($locales)->each(function ($code) {
            return $code;
        })->toArray();
    }

/**
 * Return an encoded string of app translations.
 *
 * @param $locale
 * @return string
 */
function availableTranslations($locale): string
{
    return collect(trans('app', [], $locale))->toJson();
}

/**
 * Return an array of available user roles.
 *
 * @return array
 */
function availableRoles(): array
{
    return [
        User::CONTRIBUTOR => 'Contributor',
        User::EDITOR => 'Editor',
        User::ADMIN => 'Admin',
    ];
}


/**
 * Return the configured base path url.
 *
 * @return string
 */
function dashboardPath(): string
{
    return sprintf('/%s', config('dashboard.path'));
}

/**
 * Return the configured storage path url.
 *
 * @return string
 */
function dashboardStoragePath(): string
{
    return sprintf('%s/images', config('dashboard.storage_path'));
}

/**
 * Return a valid host URL or null.
 *
 * @param  string|null  $url
 * @return string|null
 */
function parseReferer(?string $url): ?string
{
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        return parse_url($url)['host'];
    }

    return null;
}

/**
 * Generate a Gravatar for a given email.
 *
 * @param  string  $email
 * @param  int  $size
 * @param  string  $default
 * @param  string  $rating
 * @return string
 */
function gravatar(
    string $email,
    int $size = 200,
    string $default = 'retro',
    string $rating = 'g'
): string {
    $hash = md5(trim(Str::lower($email)));

    return "https://secure.gravatar.com/avatar/{$hash}?s={$size}&d={$default}&r={$rating}";
}

/**
 * Return true if dark mode is enabled.
 *
 * @param  int|null  $enabled
 * @return bool
 */
function enabledDarkMode(?int $enabled): bool
{
    return (bool) $enabled ?: false;
}

/**
 * Return true if the app is configured to use Arabic or Farsi.
 *
 * @param  string|null  $locale
 * @return bool
 */
function usingRightToLeftLanguage(?string $locale): bool
{
    return in_array($locale, ['ar', 'fa']);
}