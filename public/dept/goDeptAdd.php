<?php

/**
 * PH34 サンプル2 マスタテーブル管理 Src07/12
 *
 * 部門情報登録画面表示。
 *
 * @author Ando Takashi
 *
 * ファイル名=goDeptAdd.php
 * ディレクトリ=/ph34/scottadmindao/public/dept/
 *
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/entity/Dept.php");

$dept = new Dept();
if (isset($_SESSION["dept"])) {
    $dept = $_SESSION["dept"];
    $dept = unserialize($dept);
    unset($_SESSION["dept"]);
}
$validationMsgs = null;
if (isset($_SESSION["validationMsgs"])) {
    $validationMsgs = $_SESSION["validationMsgs"];
    unset($_SESSION["validationMsgs"]);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Ando Takashi">
    <title>部門情報追加 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph34/scottadmindao/public/css/main.css" type="text/css">
</head>

<body>
    <h1>部門情報追加</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph34/scottadmindao/public/">TOP</a></li>
            <li><a href="/ph34/scottadmindao/public/dept/showDeptList.php">部門リスト</a></li>
            <li>部門情報追加</li>
        </ul>
    </nav>
    <?php if (!is_null($validationMsgs)) { ?>
        <section id="errorMsg">
            <p>以下のメッセージをご確認ください。</p>
            <ul>
                <?php foreach ($validationMsgs as $msg) { ?>
                    <li><?= $msg ?></li>
                <?php } ?>
            <?php }
            ?>
            </ul>
        </section>
        <section>
            <p>
                情報を入力し、登録ボタンをクリックしてください。 </p>
            <form action="/ph34/scottadmindao/public/dept/deptAdd.php" method="post" class="box">
                <label for="addDpNo">
                    部門番号&nbsp;<span class="required">必須</span>
                    <input type="number" min="10" max="90" step="10" id="addDpNo" name="addDpNo" value="<?= $dept->getDpNo() ?>" required> </label><br>
                <label for="addDpName">
                    部門名&nbsp;<span class="required">必須</span>
                    <input type="text" id="addDpName" name="addDpName" value="<?=
                                                                                    $dept->getDpName() ?>" required>
                </label><br>
                <label for="addDpLoc"> 所在地
                    <input type="text" id="addDpLoc" name="addDpLoc" value="<?= $dept->getDpLoc() ?>">
                </label><br>
                <button type="submit">登録</button> </form>
        </section>
</body>

</html>