<?php declare(strict_types=1);
/**
 * phpGit - A Git wrapper for PHP
 *
 * @author   https://github.com/inhere
 * @link     https://github.com/ulue/phpgit
 * @license  MIT
 */

use PhpGit\Git;
use Symfony\Component\Filesystem\Filesystem;

require_once __DIR__ . '/../BaseTestCase.php';

class CloneCommandTest extends BaseTestCase
{
    public function testClone(): void
    {
        $git = new Git();
        $git->clone('https://github.com/kzykhys/Text.git', $this->directory);
        $git->setRepository($this->directory);

        $this->assertFileExists($this->directory . '/.git');

        $filesystem = new Filesystem();
        $filesystem->remove($this->directory);

        $git->setRepository('.');
        $git->clone('https://github.com/kzykhys/Text.git', $this->directory, ['shared' => true]);

        $this->assertFileExists($this->directory . '/.git');
    }
}
