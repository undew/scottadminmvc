<?php

/**
 * 従業員情報登録画面表示
 *
 * @author Ando Takashi
 */
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/Conf.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/entity/Emp.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/entity/Dept.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/dao/DeptDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/ph34/scottadmindao/classes/dao/EmpDAO.php");

$emp = new Emp();
$validationMsgs = null;
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

} catch (PDOException $ex) {
    $_SESSION["errorMsg"] = "DB接続に失敗しました。";
} finally {
    $db = null;
};

if (isset($_SESSION["emp"])) {
    $emp = $_SESSION["emp"];
    $emp = unserialize($emp);
    $emHiredateSet = explode("-", $emp->getEmHiredate());
    $year =  (int)$emHiredateSet[0];
    $month =  (int)$emHiredateSet[1];
    $date =  (int)$emHiredateSet[2];
    unset($_SESSION["emp"]);
}

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
    <title>従業員情報追加 | ScottAdmin Sample</title>
    <link rel="stylesheet" href="/ph34/scottadmindao/public/css/main.css" type="text/css">
</head>

<body>
    <h1>従業員情報追加</h1>
    <nav id="breadcrumbs">
        <ul>
            <li><a href="/ph34/scottadmindao/public/">TOP</a></li>
            <li><a href="/ph34/scottadmindao/public/emp/showEmpList.php">従業員情報リスト</a></li>
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
        <form action="/ph34/scottadmindao/public/emp/empAdd.php" method="post" class="box">
            <label for="addEmNo">
                従業員番号&nbsp;<span class="required">必須</span>
                <input type="number" min="1000" max="9999" id="addEmNo" name="addEmNo" value="<?= $emp->getEmNo() ?>"
                    required>
            </label><br>
            <label for="addEmName">
                従業員名&nbsp;<span class="required">必須</span>
                <input type="text" id="addEmName" name="addEmName" value="<?= $emp->getEmName() ?>" required>
            </label><br>
            <label for="addEmJob">
                役職&nbsp;<span class="required">必須</span>
                <input type="text" id="addEmJob" name="addEmJob" value="<?= $emp->getEmJob() ?>" required>
            </label><br>
            <label for="addEmMgr">
                上司番号&nbsp;<span class="required">必須</span>
                <select name="addEmMgr" id="addEmMgr">
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
            <label for="addEmHiredate">
                雇用日&nbsp;<span class="required">必須</span>
                <select name="addEmHiredateYear" id="addEmHiredateYear">
                    <?php for ($i = explode("-", $firstHiredate->getEmHiredate())[0]; $i <= date('Y'); $i++) : ?>
                    <?php if ($i === $year) : ?>
                    <option value="<?= $i ?>" selected><?= $i ?>
                        <?php else : ?>
                    <option value="<?= $i ?>"><?= $i ?>
                    </option>
                    <?php endif; ?>
                    <?php endfor; ?>
                </select>年
                <select name="addEmHiredateMonth" id="addEmHiredateMonth">
                    <?php for ($i = 1; $i <= 12; $i++) : ?>
                    <?php if ($i === $month) : ?>
                    <option value="<?= $i ?>" selected><?= $i ?></option>
                    <?php else : ?>
                    <option value="<?= $i ?>"><?= $i ?>
                    </option>
                    <?php endif; ?>
                    <?php endfor; ?>
                </select>月
                <select name="addEmHiredateDate" id="addEmHiredateDate">
                    <?php for ($i = 1; $i <= 31; $i++) : ?>
                    <?php if ($i === $date) : ?>
                    <option value="<?= $i ?>" selected><?= $i ?>
                        <?php else : ?>
                    <option value="<?= $i ?>"><?= $i ?>
                    </option>
                    <?php endif; ?>
                    <?php endfor; ?>
                </select>日
            </label><br>
            <label for="addEmSal">
                給与&nbsp;<span class="required">必須</span>
                <input type="number" min="0" id="addEmSal" name="addEmSal" value="<?= $emp->getEmSal() ?>" required>
            </label><br>
            <label for="addDeptId">
                所属部門ID&nbsp;<span class="required">必須</span>
                <select name="addDeptId" id="addDeptId">
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
            <button type="submit">登録</button> </form>
    </section>
</body>

</html>