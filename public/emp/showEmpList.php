<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/dao/EmpDAO.php");

$empList = [];
try { 

    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);

    $empDAO = new EmpDAO($db);
    $empList = $empDAO->findAll();
} catch (PDOException $ex) {
    var_dump($ex);
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
} finally {
    $db = null;
}

if (isset($_SESSION["errorMsg"])) {
    header("Location:/ph34/scottadmindao/public/error.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Ando Takashi">
    <title></title>
    <link rel="stylesheet" href="/ph34/scottadmindao/public/css/main.css" type="text/css">
</head>

<body>
    <h1>従業員情報リスト</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph34/scottadmindao/public/">TOP</a></li>
            <li>従業員情報リスト</li>
        </ul>
    </nav>
    <section>
        <p>
            新規登録は<a href="/ph34/scottadmindao/public/emp/goEmpAdd.php">こちら</a>から
        </p>
    </section>
    <section>
        <table>
            <thead>
                <tr>
                    <th>従業員ID</th>
                    <th>従業員番号</th>
                    <th>従業員名</th>
                    <th>役職</th>
                    <th>上司番号</th>
                    <th>雇用日</th>
                    <th>給与</th>
                    <th>所属部門ID</th>
                    <th colspan="2">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($empList)) {
                ?>
                    <tr>
                        <td colspan="5">該当部門は存在しません。</td>
                    </tr>
                    <?php
                } else {
                    foreach ($empList as $emp) {
                    ?>
                        <tr>
                            <td><?= $emp->getId() ?></td>
                            <td><?= $emp->getEmNo() ?></td>
                            <td><?= $emp->getEmName() ?></td>
                            <td><?= $emp->getEmJob() ?></td>
                            <td><?= $emp->getEmMgr() ?></td>
                            <td><?= $emp->getEmHiredate() ?></td>
                            <td><?= $emp->getEmSal() ?></td>
                            <td><?= $emp->getDeptId() ?></td>
                            <td>
                                <form action="/ph34/scottadmindao/public/emp/prepareEmpEdit.php" method="post">
                                    <input type="hidden" id="editEmId<?= $emp->getId() ?>" name="editEmId" value="<?= $emp->getId() ?>">
                                    <button type="submit">編集</button>
                                </form>
                            </td>
                            <td>
                                <form action="/ph34/scottadmindao/public/emp/confirmEmpDelete.php" method="post">
                                    <input type="hidden" id="deleteEmId<?= $emp->getId() ?>" name="deleteEmId" value="<?= $emp->getId() ?>">
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