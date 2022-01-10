<?php
session_start();
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>
<?php
// フォームのボタンが押されたら
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから送信されたデータを各変数に格納
    $content = $_POST["content"];
    $name = $_POST["name"];
    $birth = $_POST["birth"];
    $tel = $_POST["tel"];
    $email = $_POST["email"];
    $question = $_POST["question"];
}

// 送信ボタンが押されたら
if (isset($_POST["submit"])) {
    // 送信ボタンが押された時に動作する処理をここに記述する

    // 日本語をメールで送る場合のおまじない
    mb_language("ja");
    mb_internal_encoding("UTF-8");

    //mb_send_mail("kanda.it.school.trial@gmail.com", "メール送信テスト", "メール本文");

    // 件名を変数subjectに格納
    $subject = "［自動送信］お問い合わせ内容の確認";

    // メール本文を変数bodyに格納
    $body = <<< EOM
{$name}　様

お問い合わせありがとうございます。
以下のお問い合わせ内容を、メールにて確認させていただきました。

===================================================
【 お問い合わせ内容 】
{$content}

【 氏名 】 
{$name}

【 生年月日 】 
{$birth}

【 電話番号 】 
{$tel}

【 メール 】 
{$email}

【 その他質問 】 
{$question}
===================================================

内容を確認のうえ、回答させて頂きます。
しばらくお待ちください。
EOM;

    // 送信元のメールアドレスを変数fromEmailに格納
    $fromEmail = "hard.works.pays.off.gym@gmail.com";

    // 送信元の名前を変数fromNameに格納
    $fromName = "Hard works pays off GYM";

    // ヘッダ情報を変数headerに格納する		
    $header = "From: " . mb_encode_mimeheader($fromName) . "<{$fromEmail}>";

    // メール送信を行う
    mb_send_mail($email, $subject, $body, $header);

    // サンクスページに画面遷移させる
    header("Location: http://localhost/takagym/thanks.php");
    exit;
}
?>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>お問い合わせフォーム確認画面</title>
    <link rel="stylesheet" href="css/form_confirmation.css">
</head>

<body class="form_confirmation">
    <div>
        <h1 class="gym_name">Hard works pays off GYM</h1>
    </div>
    <div>
        <form action="confirm.php" method="post">
            <input type="hidden" name="content" value="<?php echo $content; ?>">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="birth" value="<?php echo $birth; ?>">
            <input type="hidden" name="tel" value="<?php echo $tel; ?>">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="question" value="<?php echo $question; ?>">
            <h2 class="contact-title">お問い合わせ 内容確認</h2>
            <p form_text>お問い合わせ内容はこちらで宜しいでしょうか？<br>よろしければ「送信する」ボタンを押して下さい。</p>
            <div class="form_text_block">
                <div>
                    <label class="text_content">お問い合わせ内容</label>
                    <p class="text_answer"><?php echo $content; ?></p>
                </div>
                <div>
                    <label class="text_content">お名前</label>
                    <p class="text_answer"><?php echo $name; ?></p>
                </div>
                <div>
                    <label class="text_content">生年月日</label>
                    <p class="text_answer"><?php echo $birth ?></p>
                </div>
                <div>
                    <label class="text_content">電話番号</label>
                    <p class="text_answer"><?php echo $tel; ?></p>
                </div>
                <div>
                    <label class="text_content">メールアドレス</label>
                    <p class="text_answer"><?php echo $email; ?></p>
                </div>
                <div>
                    <label class="text_content">その他質問</label>
                    <p class="text_answer"><?php echo nl2br($question);?></p>
                </div>
            </div>
            <input type="button" value="内容を修正する" onclick="history.back(-1)">
            <button type="submit" name="submit">送信する</button>
        </form>
    </div>
</body>

</html>