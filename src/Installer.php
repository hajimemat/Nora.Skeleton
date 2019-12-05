<?php

namespace Nora\Skelton;

use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Script\Event;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Installer
{
    private static $name;
    private static $email;
    private static $vendor;
    private static $project;
    private static $packageName;

    public static function preInstall(Event $event) : void
    {
        $io = $event->getIO();
        // 必要情報を取得
        self::$vendor      = self::ask($io, 'ベンダー名', 'Avap');
        self::$project     = self::ask($io, 'プロジェクト名', 'Nora-PHP-Project');
        self::$name        = self::ask($io, '名前', self::getUserName());
        self::$email       = self::ask($io, 'メールアドレス', self::getUserEmail());
        self::$packageName = vsprintf(
            '%s/%s',
            array_map(
                [__CLASS__,'normalizePackageName'],
                [self::$vendor, self::$project]
            )
        );
        // Composer Jsonを書き換える
        $json = new JsonFile(Factory::getComposerFile());
        $composerJson = self::getComposerJson(self::$vendor, self::$project, self::$packageName, $json);

        // Update Json
        $json->write($composerJson);
        $io->write("<info>composer.json for ".self::$packageName." is created.\n</info>");
    }

    public static function postInstall(Event $event) : void
    {
        $skeltonRoot = dirname(__DIR__);
        self::recursiveJob("{$skeltonRoot}", self::rename());
    }

    private static function recursiveJob(string $path, callable $job) : void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $file) {
            $job($file);
        }
    }

    private static function rename() : \Closure
    {
        $jobRename = function (SplFileInfo $file) : void {
            $fileName = $file->getFilename();
            $filePath = (string) $file;
            if ($file->isDir() || strpos($file, '.') === 0 || ! is_writable($file)) {
                return;
            }
            $contents = file_get_contents($filePath);
            $contents = str_replace('__Vendor__', ucfirst(self::$vendor), $contents);
            $contents = str_replace('__Package__', ucfirst(self::normalizePackageName(self::$project)), $contents);
            $contents = str_replace('__year__', date('Y'), $contents);
            $contents = str_replace('__name__', self::$name, $contents);
            file_put_contents($filePath, $contents);
        };
        return $jobRename;
    }

    private static function ask(IOInterface $io, string $question, string $default) : string
    {
        $ask = sprintf("\n<question>%s</question>\n\n(<comment>%s</comment>):", $question, $default);
        return $io->ask($ask, $default);
    }

    /**
     * @return array<mixed> composer.jsonの中身
     */
    private static function getComposerJson(
        string $vendor,
        string $package,
        string $packageName,
        JsonFile $json
    ) : array {
        $composerJson = $json->read();
        $composerJson = array_merge($composerJson, [
            'license' => 'proprietary',
            'name' => $packageName,
            'authors' => [
                [
                    'name' => static::$name,
                    'email' => static::$email
                ]
            ],
            'description' => '',
            'autoload' => ['psr-4' => ["{$vendor}\\{$package}\\" => 'src/']],
        ]);
        unset(
            $composerJson['autoload']['files'],
            $composerJson['scripts']['pre-install-cmd'],
            $composerJson['scripts']['pre-update-cmd'],
            $composerJson['require-dev']['composer/composer']
        );
        return $composerJson;
    }

    private static function normalizePackageName(string $name) : string
    {
        return strtolower($name);
    }

    private static function getUserName() : string
    {
        $author = shell_exec('git config --global user.name || git config user.name');
        return $author ? trim($author) : '';
    }

    private static function getUserEmail() : string
    {
        $author = shell_exec('git config --global user.email || git config user.email');
        return $author ? trim($author) : '';
    }
}
