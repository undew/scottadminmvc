<?php

/**
 * 部門情報編集。
 *
 * @author Ando Takashi
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/dao/EmpDAO.php");

$editEmId = (int) $_POST["editEmId"];
$editEmNo = $_POST["editEmNo"];
$editEmName = $_POST["editEmName"];
$editEmJob = $_POST["editEmJob"];
$editEmMgr = $_POST["editEmMgr"];
$year = $_POST["editEmHiredateYear"];
$month = $_POST["editEmHiredateMonth"];
$date = $_POST["editEmHiredateDate"];
$editEmHiredate = $year."-".$month."-".$date;
$editEmSal = $_POST["editEmSal"];
$editDeptId = $_POST["editDeptId"];

$editEmName = trim($editEmName);
$editEmJob = trim($editEmJob);

$emp = new Emp();
$emp->setId($editEmId);
$emp->setEmNo($editEmNo);
$emp->setEmName($editEmName);
$emp->setEmJob($editEmJob);
$emp->setEmMgr($editEmMgr);
$emp->setEmHiredate($editEmHiredate);
$emp->setEmSal($editEmSal);
$emp->setDeptId($editDeptId);

$validationMsgs = [];
try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);
    $empDAO = new EmpDAO($db);
    $empDB = $empDAO->findByEmpNo($emp->getEmNo());
    if (!empty($empDB) && $empDB->getId() != $editEmId) {
        $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
    }

    if (empty($validationMsgs)) {
        $emId = $empDAO->update($emp);
        if ($emId === -1) {
            $_SESSION["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
        }
    } else {
        $_SESSION["emp"] = serialize($emp);
        $_SESSION["validationMsgs"] = $validationMsgs;
    }
} catch (PDOException $ex) {
    var_dump($ex);
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
} finally {
    $db = null;
}

if (isset($_SESSION["errorMsg"])) {
    header("Location: /ph34/scottadmindao/public/error.php");
    exit;
} elseif (!empty($validationMsgs)) {
    header("Location: /ph34/scottadmindao/public/emp/prepareEmpEdit.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Ando Takashi">
    <title>従業員情報編集完了 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph34/scottadmindao/public/css/main.css" type="text/css">
</head>

<body>
    <h1>従業員情報編集完了</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph34/scottadmindao/">TOP</a></li>
            <li><a href="/ph34/scottadmindao/public/emp/showEmpList.php">従業員情報リスト</a></li>
            <li>従業員情報情報編集</li>
            <li>従業員情報編集完了</li>
        </ul>
    </nav>
    <section>
        以下の従業員情報を更新しました。 </p>
        <dl>
            <dt>従業員ID</dt>
            <dd><?= $editEmId ?></dd>
            <dt>従業員番号</dt>
            <dd><?= $emp->getEmNo() ?></dd>
            <dt>従業員名</dt>
            <dd><?= $emp->getEmName() ?></dd>
            <dt>役職</dt>
            <dd><?= $emp->getEmJob() ?></dd>
            <dt>上司番号</dt>
            <dd><?= $emp->getEmMgr() ?></dd>
            <dt>雇用日</dt>
            <dd><?= $emp->getEmHiredate() ?></dd>
            <dt>給与</dt>
            <dd><?= $emp->getEmSal() ?></dd>
            <dt>所属部門ID</dt>
            <dd><?= $emp->getDeptId() ?></dd>
        </dl>
        <p>
            従業員情報リストに<a href="/ph34/scottadmindao/public/emp/showEmpList.php">戻る</a>
        </p>
    </section>
</body>

</html>