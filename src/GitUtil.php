<?php declare(strict_types=1);
/**
 * phpGit - A Git wrapper for PHP
 *
 * @author   https://github.com/inhere
 * @link     https://github.com/ulue/phpgit
 * @license  MIT
 */

namespace PhpGit;

use Symfony\Component\Process\Process;
use function explode;
use function parse_url;
use function strpos;
use function substr;

/**
 * Class GitUtil
 *
 * @package PhpGit
 */
class GitUtil
{
    /**
     * This method is used to create a process object.
     *
     * @param string $command
     * @param array  $args
     * @param array  $options
     *
     * @return Process
     */
    public static function newProcess(string $command, array $args = [], array $options = []): Process
    {
        $isWindows = defined('PHP_WINDOWS_VERSION_BUILD');
        $options   = array_merge([
            'env_vars' => $isWindows ? ['PATH' => getenv('PATH')] : [],
            'command'  => 'git',
            'work_dir' => null,
            'timeout'  => 3600,
        ], $options);

        $cmdWithArgs = array_merge([$options['command'], $command], $args);

        $process = new Process($cmdWithArgs, $options['work_dir']);
        $process->setEnv($options['env_vars']);
        $process->setTimeout($options['timeout']);
        $process->setIdleTimeout($options['timeout']);

        return $process;
    }

    /**
     * @param string $url
     *
     * @return array
     */
    public static function parseRemoteUrl(string $url): array
    {
        // eg: git@gitlab.my.com:group/some-lib.git
        if (strpos($url, 'git@') === 0) {
            $type = 'git';

            // remove suffix
            if (substr($url, -4) === '.git') {
                $str = substr($url, 4, -4);
            } else {
                $str = substr($url, 4);
            }

            // $url = gitlab.my.com:group/some-lib
            [$host, $path] = explode(':', $str, 2);
            [$group, $repo] = explode('/', $path, 2);

            return [
                'url'    => $url,
                'type'   => $type,
                'scheme' => $type,
                'host'   => $host,
                'path'   => $path,
                'group'  => $group,
                'repo'   => $repo,
            ];
        }

        // eg: "https://github.com/ulue/swoft-component.git"
        $info = parse_url($url);
        // add
        $info['url']  = $url;
        $info['type'] = 'http';

        $uriPath = $info['path'];
        if (substr($uriPath, -4) === '.git') {
            $uriPath = substr($uriPath, 0, -4);
        }

        $info['path'] = trim($uriPath, '/');

        [$group, $repo] = explode('/', $info['path'], 2);

        $info['group'] = $group;
        $info['repo']  = $repo;

        return $info;
    }
}
