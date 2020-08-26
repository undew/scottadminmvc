<?php

/**
 * PH34 サンプル2 マスタテーブル管理 Src06/12
 * 部門情報リスト表示。
 *
 * @author Ando Takashi
 *
 * ファイル名=showDeptList.php
 * ディレクトリ=/ph34/scottadmindao/public/dept/
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/entity/Dept.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/dao/DeptDAO.php");

$deptList = [];
try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $deptDAO = new DeptDAO($db);
    $deptList = $deptDAO->findAll();
} catch (PDOException $ex) {
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
} finally {
    $db = null;
}

if (isset($_SESSION["errorMsg"])) {
    header("Location: /ph34/scottadmindao/public/error.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Ando Takashi">
    <title>部門情報リスト | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph34/scottadmindao/public/css/main.css" type="text/css">
</head>

<body>
    <h1>部門情報リスト</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph34/scottadmindao/public/">TOP</a></li>
            <li>部門情報リスト</li>
        </ul>
    </nav>
    <section>
        <p>
            新規登録は<a href="/ph34/scottadmindao/public/dept/goDeptAdd.php">こちら</a>から
        </p>
    </section>
    <section>
        <table>
            <thead>
                <tr>
                    <th>部門ID</th>
                    <th>部門番号</th>
                    <th>部門名</th>
                    <th>所在地</th>
                    <th colspan="2">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($deptList)) {
                ?>
                    <tr>
                        <td colspan="5">該当部門は存在しません。</td>
                    </tr>
                    <?php
                } else {
                    foreach ($deptList as $dept) {
                    ?>
                        <tr>
                            <td><?= $dept->getId() ?></td>
                            <td><?= $dept->getDpNo() ?></td>
                            <td><?= $dept->getDpName() ?></td>
                            <td><?= $dept->getDpLoc() ?></td>
                            <td>
                                <form action="/ph34/scottadmindao/public/dept/prepareDeptEdit.php" method="post">
                                    <input type="hidden" id="editDeptId<?= $dept->getId() ?>" name="editDeptId" value="<?= $dept->getId() ?>">
                                    <button type="submit">編集</button>
                                </form>
                            </td>
                            <td>
                                <form action="/ph34/scottadmindao/public/dept/confirmDeptDelete.php" method="post">
                                    <input type="hidden" id="deleteDeptId<?= $dept->getId() ?>" name="deleteDeptId" value="<?= $dept->getId() ?>">
                                    <button type="submit">削除</button>
                                </form>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

</html>