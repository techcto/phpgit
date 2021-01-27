<?php declare(strict_types=1);
/**
 * phpgit - A Git wrapper for PHP
 *
 * @author   https://github.com/inhere
 * @link     https://github.com/ulue/phpgit
 * @license  MIT
 */

use PhpGit\Git;
use Symfony\Component\Filesystem\Filesystem;

require_once __DIR__ . '/../BaseTestCase.php';

class ShowCommandTest extends BaseTestCase
{
    public function testShow(): void
    {
        $filesystem = new Filesystem();

        $git = new Git();
        $git->init($this->directory);
        $git->setRepository($this->directory);

        $filesystem->dumpFile($this->directory . '/README.md', 'foobar');
        $git->add('README.md');
        $git->commit('Initial commit');

        $git->show('master', ['format' => 'oneline']);
    }
}
