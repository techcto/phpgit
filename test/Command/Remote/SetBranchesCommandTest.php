<?php declare(strict_types=1);
/**
 * phpgit - A Git wrapper for PHP
 *
 * @author   https://github.com/inhere
 * @link     https://github.com/ulue/phpgit
 * @license  MIT
 */

use PhpGit\Git;

require_once __DIR__ . '/../../BaseTestCase.php';

class SetBranchesCommandTest extends BaseTestCase
{
    public function testSetBranches(): void
    {
        $git = new Git();
        $git->clone('https://github.com/kzykhys/Text.git', $this->directory);
        $git->setRepository($this->directory);

        $git->remote->branches('origin', ['master']);
    }

    public function testSetBranchesAdd(): void
    {
        $git = new Git();
        $git->clone('https://github.com/kzykhys/Text.git', $this->directory);
        $git->setRepository($this->directory);

        $git->remote->branches->add('origin', ['gh-pages']);
    }
}
