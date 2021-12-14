# はじめに
VaccImageは、イントラネット内においてワクチン接種者およびバイアル数などの管理をおこなことを目的としたものWEBアプリケーションです。Linux OS上のXAMPPで稼働することを確認しております。WEBアプリケーションであるため、クライアント側の環境にはあまり依存しておりません。  
ただし、管理者がある程度、SQL、PHP、HTMLについての知識を有していることを前提としております。  
セキュリティ対策は必要最小限度となっております。運用時に注意するようにしてください。  
なお、2021/12/14以後、Ver1.0系のフォルダは旧ファイルとし、以後はGitHubによるバージョン管理に変更します。

Windows10での環境構築については、スクショを用いて「vaccimageWin10Install.pdf」にアップいたしました。「vaccimageWin10SetUpHowTo.pdf」もあります(旧ファイルのフォルダにうつした2021/12/14)。
**この「README.md」と「vaccimageWin10Install.pdf」、「vaccimageWin10SetUpHowTo.pdf」の3つをご覧いただき、インストール、セットアップの参考にしていただけましたら幸いです。**  
また、より適したCodeなどの情報提供も歓迎です。当方、*PHP* & *SQL* はまだ初学者なので。

# 動作環境について
## サーバー側
VaccImageは以下の環境で動作を確認しておりまkす。
- Ubuntu 18.04.5 LTS(最小構成)
- Ubuntu 20.04.2 LTS(最小構成)
- CentOS Stream 8
- Windows10 Pro(Homeでは試してませんがおそらく問題ないものと思われます)。
- (PHPのBCMathについてはXamppに最初からインストールされておりました。ない場合はバイアル数の計算のためにインストールしていただく必要があります。)
- GUIなしのUbuntuServerでは事実上設定が困難と思われます。
- 80番ポートを邪魔するようなアプリ(SKYPEなど)は予め削除することをオススメします。

## クライアント側
- Windows 10 Pro/Home環境下での、
    - Edge Browser
    - Internet Explorer
    - Chrome Browser
- Ubuntu 18.04.5 LTSおよび20.04.2LTS環境下での、
    - Chrome Browser
- MacOSでの動作は確認しておりませんがおそらく問題ないものと思われます。
- HD(1366*768)未満の画素数では表示範囲内に収まらない可能性があります。

# 導入手順
VaccImageはXAMPP下での稼働を確認しております。
- XAMPP for Linux 8.0.6 または 8.0.3

## 環境構築について
サーバー側での環境構築について述べます。CentOSについてもほぼ同様の手順で可能となります。  
なおUbuntuやCentOS自体のインストール、XAMPPの設定についての基本的な事柄についてはここでは記載しておりません。基本事項はWEBなどで調べてからこのドキュメントを読んでください。

### XAMPPインストール
XAMPPのウェブサイトから.runファイルをダウンロードしてください。今回は、
```
xampp-linux-x64-8.0.6-0-installer.run
```
を、
```
~/Downloads
```
にダウンロードしました。  
まずコマンドで、
```
chmod +x xampp-linux-x64-8.0.6-0-installer.run 
```
を実行して、.runファイルに実行権限を与えてから、  
```
sudo ./xampp-linux-x64-8.0.6-0-installer.run 
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
を行ってください。これが初期にはインストールされておりませんようです(2021/05/31時点)。  
その他の点に関してはほぼすべてUbuntuと同等の方法で環境構築が可能ですが、CentOS自体は状況がやや流動的なようです。

### htdocsフォルダへのvaccimageフォルダの移動
```
/opt/lampp/htdocs
```
への「vaccimage」フォルダのコピーも管理者権限を取得しないとできません(Windowsではとくに権限は不要なようですが)。

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
である必要があります(SEがPHPの編集をする場合は書き込み権限+wも必要です)。
```
sudo chmod -R +r /opt/lampp/htdocs/vaccimage/
```
などとし読み込みの権限を与えてください。

### MariaDBの設定
次に、MariaDB(以下、MySQL)の設定について記載します。  
VaccImageは、初期設定ではパスワードは設定しておりませんが、運用時は設定することをおすすめします。  
まず、
```
 sudo /opt/lampp/bin/mysql
```
とし、MySQLにログインしてください(このときも管理者権限が必要になります)。 
次に、
```
create database vaccimage;
use vaccimage;
```
をしてください。「vaccimage」は小文字で、この名称は変更しないでください。  
次に患者登録用(allmember.sql)、ワクチン接種歴登録用(vaccineall.sql)、バイアル入荷・修正歴登録用(countshusei.sql)のそれぞれのデータベースの登録を行います。
このコマンドは、「Vaccimage」下層の「sql」フォルダにしまわれており下記を実行したら使用可能となります。
```
\. /opt/lampp/htdocs/vaccimage/sql/allmember.sql
\. /opt/lampp/htdocs/vaccimage/sql/vaccineall.sql
\. /opt/lampp/htdocs/vaccimage/sql/countshusei.sql
```
これら3つのデータベースを登録したあと、下記を実行してください。各ワクチンのViewの設定になります。
```
\. /opt/lampp/htdocs/vaccimage/sql/ViewSet.sql
```
現在の実装はインフルエンザワクチンのみ(2021年6月1日公開時点)ですが、ファイザーとモデルナ、アストラゼネカの新型コロナウイルス感染症のワクチンについても対応予定です。  

最後に、時間帯の設定変更を行います。  
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

### 日々の設定
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

## 部署の設定について(難しいが重要)
部署の選択肢が現時点ではHTMLのinputタグのList頼みになっていること。該当するページは、
```
http://localhost/vaccimage/PageOrderSearch.php
http://localhost/vaccimage/PagePtRegistration.php
http://localhost/vaccimage/PagePtSearch.php
```
です。いずれJSONなどからの読み込み、部分的なPHPからの読み込みなどで対応したいと考えております。従いまして、各SE、情報管理者に置かれましては各施設の部署や状況に応じて**直接HTMLを編集していただく**必要性があります。
何れも修正箇所は、
```
<optgroup label="患者(職員家族含)">
<option value=""></option>
<option value="外来患者">外来患者</option>
<option value="入院患者">入院患者</option>
<option value="職員家族">職員家族</option>
</optgroup>
<optgroup label="職員">
<option value="外来・救急">外来・救急</option>
<option value="病棟">病棟</option>
<option value="医局">医局</option>
<option value="医事課">医事課</option>
</optgroup>
```
に該当する部分です。HTMLの参考書などをみて各病院の状況に応じてListを変更してください。

### バイアル数のカウントのページについて(やや難しい)
現在、バイアル数カウントで動かしているのは、
```
http://localhost/vaccimage/PageShowInfluenzaResult.php
```
のみですが、このページは設定がややこしいので別に項を設けて説明します。  
このページは、
```
【！修正箇所！】
```
タグの部分を編集して使用していただくことになります。  
具体的には、
```
$startDate = '2021-05-01';
$goalDate = '2021-06-30';   //【！修正箇所！】ここでカウント期間開始日と終了日つまり期間の指定をする(期間外のバイアル、接種者はいっさいカウントされません。)
```
の"$startDate"と"$goalDate"の修正を行ってください。  
この開始日と終了日は各施設の状況に応じて設定が必須となります！  
以下の修正箇所は、アプデを待っていただくのでも構いませんが。

```
$sql = "SELECT * FROM CountInfluenza WHERE ( vaccdate >= '$startDate' AND vaccdate <= '$goalDate' ) ORDER BY vaccdate ASC; ";  
    //【！修正箇所！】ここで引用するViewを指定してください。インフル: CountInfluenza、ファイザー: CountPFECOVID19、モデルナ: CountMRNACOVID19、アストラゼネカ: CountAZNCOVID19
```
の"CountInfluenza"を適用したいワクチン種に変更してください。

```
//【！修正箇所！】ここでrとnの設定
$r = 2; //ratio インフルなら投与量が大人:子供=2:1 なので r=2 です。
$n = 2; //1バイアルで接種可能な大人の人数　インフルは2人なのでn=2です。
//インフルエンザは1バイアルから大人2人、小人4人、で計算しております。関数をよくみてワクチン種によって変更を。
```
の"$r"と"$n"の修正を行ってください。

```

$sql = "SELECT * FROM CountInfluenzaV WHERE ( shuseidate >= '$startDate' AND shuseidate <= '$goalDate')  ORDER BY shuseidate ASC;"; 
//【！修正箇所！】ここで引用するViewを指定してください。インフル: CountInfluenzaV、ファイザー: CountPFECOVID19V、モデルナ: CountMRNACOVID19V、アストラゼネカ: CountAZNCOVID19V
```
```
$sql = "SELECT shuseidate, sum(shuseicount) FROM CountInfluenzaV WHERE ( shuseidate >= '$startDate' and shuseidate <= '$goalDate') GROUP BY shuseidate ORDER BY shuseidate ASC;";
//【！修正箇所！】ここで引用するViewを指定してください。インフル: CountInfluenzaV、ファイザー: CountPFECOVID19V、モデルナ: CountMRNACOVID19V、アストラゼネカ: CountAZNCOVID19V
```
のCountInfluenzaVの修正、を適宜行ってください。

これらの箇所を修正していただくことになります。  
なお修正する場合は、
```
chmod +r /opt/lampp/htdocs/vaccimage/PageShowInfluenzaResult.php
```
をして書き込み権限を与えてからにしてください。  
上記、とくにカウント区切りの日付の変更は運用上必須となるのでよく確認してください。

### その他の注意点
- 年齢のカウントは公的機関で用いられるような厳密なものではありません。あくまで目安です。
- 1分ごとのページ更新などのJavascriptの機能は設けておりません。従いまして、ある程度の感覚で「更新」ボタンを押しながら運用をしていただくことを周知してください。
- 患者IDのチェックディジットは設けておりません。各施設の患者ID登録状況に応じて設けることもできます。

# Q&A
- サーバー側がWindowsOSでの稼働を確認していない理由は？  
 -> WindowsServerが非常に高価であることと、通常のWindowsのHomeやProではサーバー機能を有していないため(非公式ながらWindowsは同時アクセス台数が10台までに制限されているとのこと)。Windows10Proでの接続台数が限られた環境での稼働は確認しております。

- インフルエンザワクチン以外への対応は？  
 -> いずれ実装予定です。ファイザー、モデルナ、アストラゼネカの新型コロナウイルス感染症ワクチンに対応したいと考えております。

- 予約入力数の制限機能は？  
 -> 現時点ではありません。実装も難しいかもしれません。

- 当日の未接種の扱いについて。当日の接種がすべて終了しないと、バイアルの残数が不明なのか？  
 -> 当日接種については、未接種ふくめての全カウントを当日朝から出すようにしております。しかし前日までの未接種と明日以後の接種者はカウントしません。不適切な入力は間違ったカウントの元になるので注意してください。事後でもいいので過去の接種分と未来日の予約をきちんと入力してください。

- バイアル数のカウントの区切りについてはどう考えていますか？  
 -> ワクチン接種の管理するMySQLのデータベースは一つなので、PHP側で人為的に区切る設定にしております。正確には、PageShowInfluenzaResult.phpのPHPをご参照いただき、tableに出力する範囲を設定することでバイアル数をカウントする仕様です。詳しくは、"バイアル数のカウントのページについて"の項を御覧ください。

- 今後の更新頻度は？  
 -> 状況に応じて、不定期です。GitHub上で更新していきます。

# 問い合わせ先
Mail: yoh.yasushi@gmail.com  
Twitter: https://twitter.com/Yoh_Yasushi  
GitHub: https://github.com/YohYasushi
Blog: https://yohyasushi.blogspot.com/
