<?php

namespace Nora\Skelton;

use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Script\Event;

class Install
{
    private $name;
    private $email;

    public function __invoke(Event $event) : void
    {
        $io = $event->getIO();
        // 必要情報を取得
        $vendor  = $this->ask($io, 'ベンダー名', 'Avap');
        $project = $this->ask($io, 'プロジェクト名', 'Nora-PHP-Project');
        $this->name    = $this->ask($io, '名前', $this->getUserName());
        $this->email   = $this->ask($io, 'メールアドレス', $this->getUserEmail());
        $packageName = vsprintf('%s/%s', array_map([$this,'normalizePackageName'], [$vendor, $project]));
        $io->write("<info>composer.json for {$packageName}</info>");
        // Composer Jsonを書き換える
        $json = new JsonFile(Factory::getComposerFile());
        $composerJson = $this->getComposerJson($vendor, $project, $packageName, $json);
        // $json->write($composerJson);
        // $json->write(dirname(__DIR__).'/composer-dist.json');
        var_dump($composerJson);
        //print($composerJson);
    }

    private function ask(IOInterface $io, string $question, string $default) : string
    {
        $ask = sprintf("\n<question>%s</question>\n\n(<comment>%s</comment>):", $question, $default);
        return $io->ask($ask, $default);
    }

    /**
     * @return array<mixed> composer.jsonの中身
     */
    private function getComposerJson(string $vendor, string $package, string $packageName, JsonFile $json) : array
    {
        $composerJson = $json->read();
        $composerJson = array_merge($composerJson, [
            'license' => 'proprietary',
            'name' => $packageName,
            'authors' => [
                [
                    'name' => $this->name,
                    'email' => $this->email
                ]
            ],
            'description' => '',
            'autoload' => ['psr-4' => ["{$vendor}\\{$package}" => 'src/']],
        ]);
        var_dump($composerJson);
        // unset(
        //     $composerJson['autoload']['files'],
        //     $composerJson['scripts']['pre-install-cmd'],
        //     $composerJson['scripts']['pre-update-cmd'],
        //     $composerJson['scripts']['post-create-project-cmd'],
        //     $composerJson['require-dev']['composer/composer']
        // );
        return $composerJson;
    }

    private function normalizePackageName(string $name) : string
    {
        return strtolower($name);
    }

    private function getUserName() : string
    {
        $author = shell_exec('git config --global user.name');
        return $author ? trim($author) : '';
    }

    private function getUserEmail() : string
    {
        $author = shell_exec('git config --global user.name');
        return $author ? trim($author) : '';
    }
}
