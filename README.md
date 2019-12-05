# Nora PHP Skelton (Avap Style)

## 対象ユーザと目的

以下の意見に同意する人にのみ使いやすいスケルトンです
---

* エディタはNeovim
* フレームワークは自作 or Nora派
* ドキュメント書くときはreStructuredText+Sphinx
* とりあえずWebPackは使う
* UIはReactで作る
* Ramlとか好き

現在の使用目的
---

PHPライブラリ作成用の雛形

## 必要な追加物

### [Phive](https://github.com/phar-io/phive)

PHPアーカイブ

```bash
wget -O phive.phar https://phar.io/releases/phive.phar
wget -O phive.phar.asc https://phar.io/releases/phive.phar.asc
gpg --keyserver pool.sks-keyservers.net --recv-keys 0x9D8A98B29B2D5D79
gpg --verify phive.phar.asc phive.phar
chmod +x phive.phar
sudo mv phive.phar /usr/local/bin/phive
```

### [phpunit](https://github.com/sebastianbergmann/phpunit)
### [phpdox](https://github.com/theseer/phpdox)

PHPアーカイブ

## 謝辞

* [BEAR.SundayさんのSkelton](https://github.com/bearsunday/BEAR.Skeleton)を参考に作っています。

