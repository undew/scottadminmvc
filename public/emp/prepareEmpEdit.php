<?php

/**
 * 従業員情報編集画面表示。
 *
 * @author Ando Takashi
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/entity/Dept.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/dao/DeptDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/dao/EmpDAO.php");

$emp = new Emp();
$dept = new Emp();
$validationMsgs = null;
// 空要素配置
$year = "";
$month = "";
$date = "";

try {
    $db = new PDO(Conf::DB_DNS, Conf::DB_USERNAME, Conf::DB_PASSWORD);

    $deptDAO = new DeptDAO($db);
    $deptList = $deptDAO->findAll();

    $empDAO = new EmpDAO($db);
    $empList = $empDAO->findAll();
    $firstHiredate = $empDAO->FirstHiredate();

    if (isset($_POST["editEmId"])) {
        $editEmId = $_POST["editEmId"];
        $emp = $empDAO->findByPK($editEmId);
        $emHiredateSet = explode("-", $emp->getEmHiredate());
        $year =  (int)$emHiredateSet[0];
        $month =  (int)$emHiredateSet[1];
        $date =  (int)$emHiredateSet[2];
    }

    if (empty($emp)) {
        $_SESSION["errorMsg"] = "従業員情報の取得に失敗しました。";
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
}

if (isset($_SESSION["emp"])) {
    $emp = $_SESSION["emp"];
    $emp = unserialize($emp);
    $emHiredateSet = explode("-", $emp->getEmHiredate());
    $year =  (int)$emHiredateSet[0];
    $month =  (int)$emHiredateSet[1];
    $date =  (int)$emHiredateSet[2];
    unset($_SESSION["emp"]);
    if (isset($_SESSION["validationMsgs"])) {
        $validationMsgs = $_SESSION["validationMsgs"];
        unset($_SESSION["validationMsgs"]);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Ando Takashi">
    <title>従業員情報編集 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph34/scottadmindao/public/css/main.css" type="text/css">
</head>

<body>
    <h1>従業員情報編集</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph34/scottadmindao/public/">TOP</a></li>
            <li><a href="/ph34/scottadmindao/public/emp/showempList.php">従業員情報リスト</a></li>
            <li>従業員情報編集</li>
        </ul>
    </nav>
    <?php if (!is_null($validationMsgs)) { ?>
    <section id="errorMsg">
        <p>以下のメッセージをご確認ください。</p>
        <ul>
            <?php foreach ($validationMsgs as $msg) { ?>
            <li><?= $msg ?></li>
            <?php } ?>
        </ul>
    </section>
    <?php
    }
    ?>
    <section>
        <p>情報を入力し、更新ボタンをクリックしてください。</p>
        <form action="/ph34/scottadmindao/public/emp/empEdit.php" method="post" class="box">
            従業員ID:&nbsp;<?= $emp->getId() ?><br>
            <input type="hidden" name="editEmId" value="<?= $emp->getId() ?>">
            <label for="editEmNo">
                従業員番号&nbsp;<span class="required">必須</span>
                <input type="number" min="1000" max="9999" id="editEmNo" name="editEmNo" value="<?= $emp->getEmNo() ?>"
                    required>
            </label><br>
            <label for="editEmName">
                従業員名&nbsp;<span class="required">必須</span>
                <input type="text" id="editEmName" name="editEmName" value="<?= $emp->getEmName() ?>" required>
            </label><br>
            <label for="editEmJob">
                役職&nbsp;<span class="required">必須</span>
                <input type="text" id="editEmJob" name="editEmJob" value="<?= $emp->getEmJob() ?>" required>
            </label><br>
            <label for="editEmMgr">
                上司番号&nbsp;<span class="required">必須</span>
                <select name="editEmMgr" id="editEmMgr">
                        <option value="0">0 上司なし</option>
                            <?php foreach ($empList as $item) : ?>
                                <?php if ($item->getEmNo() === $emp->getEmMgr()) : ?>
                                <option value="<?= $item->getEmNo() ?>" selected>
                                    <?php echo $item->getEmNo() . " " . $item->getEmName(); ?>
                                </option>
                                <?php else : ?>
                                <option value="<?= $item->getEmNo() ?>">
                                    <?php echo $item->getEmNo() . " " . $item->getEmName(); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                </select>
            </label><br>
            <label for="editEmHiredate">
                雇用日&nbsp;<span class="required">必須</span>
                <select name="editEmHiredateYear" id="editEmHiredateYear">
                        <?php for ($i = explode("-", $firstHiredate->getEmHiredate())[0]; $i <= date('Y'); $i++) : ?>
                            <?php if ($i === $year) : ?>
                                <option value="<?= $i ?>" selected><?= $i ?></option>
                            <?php else : ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                </select>年
                <select name="editEmHiredateMonth" id="editEmHiredateMonth">
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                        <?php if ($i === $month) : ?>
                            <option value="<?= $i ?>" selected><?= $i ?></option>
                        <?php else : ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endif; ?>
                    <?php endfor; ?>
                </select>月
                <select name="editEmHiredateDate" id="editEmHiredateDate">
                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                        <?php if ($i === $date) : ?>
                            <option value="<?= $i ?>" selected><?= $i ?></option>
                        <?php else : ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php endif; ?>
                    <?php endfor; ?>
                </select>日
            </label><br>
            <label for="editEmSal">
                給与&nbsp;<span class="required">必須</span>
                <input type="number" min="0" id="editEmSal" name="editEmSal" value="<?= $emp->getEmSal() ?>" required>
            </label><br>
            <label for="editDeptId">
                所属部門ID&nbsp;<span class="required">必須</span>
                <select name="editDeptId" id="editDeptId">
                    <?php foreach ($deptList as $dept) : ?>
                    <?php if ($dept->getId() == $emp->getDeptId()) : ?>
                    <option value="<?= $dept->getId() ?>" selected>
                        <?php echo $dept->getDpNo() . " " . $dept->getDpName(); ?>
                    </option>
                    <?php else : ?>
                    <option value="<?= $dept->getId() ?>">
                        <?php echo $dept->getDpNo() . " " . $dept->getDpName(); ?>
                    </option>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </label><br>
            <button type="submit">更新</button>
        </form>
    </section>
</body>

</html