# はじめに
VaccImage(ばっくいまーじゅ)は、イントラネット内においてワクチン接種者およびバイアル数などの管理をおこなことを目的としたものWEBアプリケーションです。Linux上のXAMPPで稼働することを確認しております。WEBアプリケーションであるため、クライアント側の環境にはあまり依存しておりません。  
ただし、管理者がLinux、SQL、PHP、HTML、CSSなどについての知識を有していることを前提としております。  
セキュリティ対策は必要最小限度となっております。運用時に注意するようにしてください。  
なお、2021/12/14以後、Ver1.0系のフォルダは旧ファイルとし、以後はGitHubによるバージョン管理に変更します。
より適したCodeなどの情報提供も歓迎です。当方、*PHP* & *SQL* はまだ初学者なので。  
### Ver2について
Ver2の特徴としては、**バイアル計算のみならず、部署、ワクチン種別などの設定をすべてSQLで行っていること**、です。これによりVer1で必要だった部署などの設定変更に合わせたPHPやHTML(とくにList界隈の変更)が不要となりました。HTMLのLIST側にはSQLの変更が自動的に反映されます。  
その代わり、期間ごとのワクチンの区切りが対応不可となりました。今後の動静により検討する予定です。

# 動作環境について
## サーバー側
以下の環境で動作を確認しております。
- Ubuntu 18.04.5 LTS(最小構成 Ver2では確認しておりません)
- Ubuntu 20.04.2 LTS(最小構成)
- CentOS Stream 8(Ver2では確認予定)
- Windows10 Pro(2022/01/20 Ver2で試したところ、稼働しませんでした)。  
ただし、
- 推奨OSは18.04以降のUbuntuとします(WindowsServerOSでの動作は確認しておりません)。
- GUIなしのUbuntuServerでは事実上設定が困難と思われます。
- 80番ポートを邪魔するようなアプリ(SKYPEなど)は予め削除することをオススメします。

## クライアント側
Windows 10 Pro/Homeおよび 11 Home環境下での、
- Edge Browser
- Chrome Browser  
- Firefox Browser  
Ubuntu 18.04.5 LTS(Ver2では未確認)および20.04.2LTS環境下での、
- Chrome Browser
- Firefox Browser  
ただし、
- MacOSでの動作は確認しておりませんがおそらく問題ないものと思われます。
- HD(1366*768)未満の画素数では表示範囲内に収まらない可能性があります。
- ブラウザのバージョンについては適宜、とします。

# 導入手順
VaccImageはXAMPP下での稼働を確認しております。
- XAMPP for Linux 8.1.0

## 環境構築について
サーバー側での環境構築について述べます。  
なおUbuntuやCentOS自体のインストール、XAMPPの設定についての基本的な事柄についてはここでは記載しておりません。基本事項はWEBなどで調べてからこのドキュメントを読んでください。

### Linux環境下でのインストール
### XAMPPインストール
XAMPPのウェブサイトから.runファイルをダウンロードしてください。
```
xampp-linux-x64-X.X.X-X-installer.run
```
を、
```
~/Downloads
```
にダウンロードしました(Xはバージョン)。  
まずコマンドで、
```
chmod +x xampp-linux-x64-8.0.6-0-installer.run 
```
を実行して、.runファイルに実行権限を与えてから、  
```
sudo ./xampp-linux-x64-X.X.X-X-installer.run
```
を行って.runファイルを走らせてください。これには管理者権限が必要になります。

.runファイルの展開にはしばらく時間がかかります。(各種設定は初期設定のままで問題ないかと思われます)。  
展開後、
```
http://localhost
```
をウェブブラウザで入力し、Xamppのトップページが立ち上がることを確認してください。これができていない場合はXAMPPのインストールができておりません。最初からやり直してください。  

### CentOSでの注意点
- パッケージ管理にはaptではなくてyumを使ってください(既知のことと思いますが)。
- libnslがインストールされていないので、
```
sudo yum install libnsl
```
を行ってください。これが初期にはインストールされておりませんようです(2021/05/31時点 Ver2では確認予定です)。  
その他の点に関してはほぼすべてUbuntuと同等の方法で環境構築が可能ですが、CentOS自体の状況がやや流動的なようです。

### htdocsフォルダへのvaccimageフォルダの移動
```
/opt/lampp/htdocs
```
への「vaccimage」フォルダのコピーも管理者権限を取得しないとできません(Windowsではとくに権限は不要なようですが)。  
なお、「vaccimage」フォルダは、  [VaccImage](https://github.com/YohYasushi/VaccImage/tree/main/vaccimage "VaccImage") から落としてください。  

今回は、
```
~/Downloads
```
に「vaccimage」フォルダをダウンロードしました。

htdocsは、
```
/opt/lampp/htdocs
```
である設定で話を進めます。  
管理者権限でもって「vaccimage」フォルダをコピーするために、
```
sudo cp -r vaccimage/ /opt/lampp/htdocs
```
を実行してください。  
これで「vaccimage」フォルダがhtdocs下層にコピーされました。  
ここで、
```
http://localhost/vaccimage
```
を打鍵しTopPageが表示されたら良いのですが、表示されない場合は権限の変更が必要になります。   
htdocs下層に落とした「vaccimage」フォルダについては権限が少なくとも、
```
-r--r--r--
```
である必要があります(管理者がPHPの編集をする場合は書き込み権限+wも必要です)。
```
sudo chmod -R +r /opt/lampp/htdocs/vaccimage/
```
などとし読み込みの権限を与えてください。

### MariaDBの設定
次に、MariaDB(または、MySQL)の設定について記載します。  
VaccImageは、初期設定ではパスワードは設定しておりませんが、運用時は設定することをおすすめします。  
まず、
```
 sudo /opt/lampp/bin/mysql
```
とし、MySQLにログインしてください(このときも管理者権限が必要になります)。 
次に、
```
use vaccimage;
```

を行ってVaccImage(CLIでは小文字です、ここ要注意)を使う設定をした後、

```
\. /opt/lampp/htdocs/vaccimage/sql/initsetupLinux.sql
```
をしてください(大量のエラーを吐きますが実際は問題ないようです <= 検証予定)。  

最後に、時間帯の設定変更を行います。  
なおここでも権限の変更が必要になることがあります。  
php.iniファイルの設定を変更することでUTCからAsia/Tokyoに時間帯の設定をできます。  
Ubuntuではphp.iniは、
```
/opt/lampp/etc/
```
に存在します。これをテキストエディタで開いて、
```
; Defines the default timezone used by the date functions
; http://php.net/date.timezone
date.timezone=UTC
```
の部分を*date.timezone=Asia/Tokyo*に変更してからXAMPPを再起動してください。  
再起動後、ブラウザを立ち上げて、
```
http://localhost/dashboard/phpinfo.php
```
で*timezone*が*Asia/Tokyo*変更されていることを確認してください。  
なお、初期から*Asia/Tokyo*になっている場合はもちろん変更は不要です。

最後に、サーバー側のIPアドレスを固定し、取得してください。  


以上で、セットアップが完了します。  
MySQLデータベースのバックアップは自動化しておりません。適宜、手動でバックアップするようにしてください。

### XAMPPの起動方法
サーバーの起動をしただけでは、XAMPPは立ち上がらないので、
```
sudo /opt/lampp/xampp start
```
を毎回、行ってください。  
停止する場合は、
```
sudo /opt/lampp/xampp stop
```
を行ってください。  
```
sudo /opt/lampp/xampp
```
を行うと、XAMPPの機能一覧を見ることができます。


### Windows10Pro環境下でのインストール
Ubuntuを参考にしてセットアップを行ってください。 
過去の設定方法は、「OldFiles」フォルダに画像を添付したPDFがありますので参考にしてください。  
なお、労力の問題からVer2以後はWindows10Pro向けにイラスト入りのPDFの作成は行いませんが、基本的なことは変わらないので、初回版を参考にするようにしてください。  

### クライアント側の設定
とくにインストールを要するようなものはございません。上記で取得したIPアドレスをあわせて下記のようなリンクを作成し、各クライアントのデスクトップに配布すると便利だと思われます。  
例えばサーバーのIPアドレスが
```
192.168.10.13
```
の場合、
```
http://192.168.10.13/vaccimage/
```
がTopPageへのショートカットとなります。


## 施設ごとの状況に合わせた各種設定について
### 部署の設定について　サンプルデータについてなど
Ver2で決定的に変わったのが、部署設定をSQL側ですべて行うことができたことです。これにより面倒くさいPHP側をいじる必要性がなくなりました。  
部署の設定SQLは、
```
/opt/lampp/htdocs/vaccimage/sql/departments.sql
```
です。  
なお、部署、患者データのサンプルは、
```
\. /opt/lampp/htdocs/vaccimage/sql/jikkendata.sql
```
を実行してみてください。ぜひとも、初回の動作確認に使ってみてください。  
また、
```
\. /opt/lampp/htdocs/vaccimage/sql/vaccinetypes.sql
```
において、デフォルトでインフルエンザワクチン、ファイザー、モデルナ、アストラゼネカのCOVID19のワクチンに対応しております。接種可能人数なども入力済みです。確認しておいてください。  

### ワクチンバイアルの計算用の設定
### 部署の設定
### 職員種別の設定


### その他の注意点
- 年齢のカウントは公的機関で用いられるような厳密なものではありません。あくまで目安です。
- 1分ごとのページ更新などのJavascriptの機能は設けておりません。従いまして、ある程度の感覚で「更新」ボタンを押しながら運用をしていただくことを周知してください。今後、改善予定です。
- 患者IDのチェックディジットは設けておりません。各施設の患者ID登録状況に応じて設けることもできます。
- アルファベット込の患者IDへの対応は2022/01/20の時点ではできておりません。今後、改善予定です。  

# Q&A
- サーバー側がWindowsServerOSでの稼働を保障していない理由は？  
 -> WindowsServerが非常に高価であることと、通常のWindowsのHomeやProではサーバー機能を有していないため(非公式情報ながら通常のWindowsOSは同時アクセス台数が10台までに制限されているとのこと)。Ver2では10Proでも稼働しませんでした。XAMPP側の問題かもしれませんが、検証予定です。情報も希望します。  

- 予約入力数の制限機能は？  
 -> 現時点ではありません。実装も難しいかもしれません。未来日の予約入力数の制限があればいいのですが…。

- 当日の未接種の扱いについて。当日の接種がすべて終了しないと、バイアルの残数が不明なのか？  
 -> SQLで処理するようにしたVer2から対応しました。

- バイアル数のカウントの区切りについてはどう考えていますか？  
 -> 2022/01/20記載。Ver2では対応しておりません。

- 今後の更新頻度は？  
 -> 状況に応じて、不定期です。GitHub上で更新していきます。

# 問い合わせ先
Mail: yoh.yasushi@gmail.com  
Twitter: https://twitter.com/Yoh_Yasushi  
GitHub: https://github.com/YohYasushi  
Qiita: https://qiita.com/Yoh_Yasushi  
Blog: https://yohyasushi.blogspot.com/   