<?php

/**
 * PH34 サンプル3 マスタテーブル管理DAO版 Src06/13
 *
 * @author Ando Takashi
 *
 * ファイル名=Dept.php
 * ディレクトリ=/ph34/scottadmindao/classes/dao/
 */

/**
 * deptテーブルへのデータ操作クラス。
 */
class DeptDAO
{
    /**
     * @var PDO DB接続オブジェクト
     */
    private $db;

    /**
     * コンストラクタ
     *
     * @param PDO $db DB接続オブジェクト
     */
    public function __construct(PDO $db)
    {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $db;
    }

    /**
     * 主キーidによる検索。
     *
     * @param integer $id 主キーであるid。
     * @return Dept 該当するDeptオブジェクト。ただし、該当データがない場合はnull。
     */
    public function findByPK(int $id): ?Dept
    {
        $sql = "SELECT * FROM depts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $dept = null;
        if ($result && $row = $stmt->fetch()) {
            $idDb = $row["id"];
            $dpNo = $row["dp_no"];
            $dpName = $row["dp_name"];
            $dpLoc = $row["dp_loc"];
            $dept = new Dept();
            $dept->setId($idDb);
            $dept->setDpNo($dpNo);
            $dept->setDpName($dpName);
            $dept->setDpLoc($dpLoc);
        }
        return $dept;
    }

    /**
     * 部門番号による検索。
     *
     * @param integer $dpNo 主キーであるid。
     * @return Dept 該当するDeptオブジェクト。ただし、該当データがない場合はnull。
     */
    public function findByDpNo(int $dpNo): ?Dept
    {
        $sql = "SELECT * FROM depts WHERE dp_no = :dp_no";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":dp_no", $dpNo, PDO::PARAM_INT);
        $result = $stmt->execute();
        $dept = null;
        if ($result && $row = $stmt->fetch()) {
            $id = $row["id"];
            $dpNoDB = $row["dp_no"];
            $dpName = $row["dp_name"];
            $dpLoc = $row["dp_loc"];
            $dept = new Dept();
            $dept->setId($id);
            $dept->setDpNo($dpNoDB);
            $dept->setDpName($dpName);
            $dept->setDpLoc($dpLoc);
        }
        return $dept;
    }

    /**
     * 全部門情報検索。
     * @return array
     * 全部門情報が格納された連想配列。キーは部門番号、値はDeptエンティティオブジェクト。
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM depts ORDER BY dp_no";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $deptList = [];
        while ($row = $stmt->fetch()) {
            $id = $row["id"];
            $dpNo = $row["dp_no"];
            $dpName = $row["dp_name"];
            $dpLoc = $row["dp_loc"];
            $dept = new Dept();
            $dept->setId($id);
            $dept->setDpNo($dpNo);
            $dept->setDpName($dpName);
            $dept->setDpLoc($dpLoc);
            $deptList[$id] = $dept;
        }
        return $deptList;
    }

    /**
     * 部門情報登録。
     *
     * @param Dept $dept 登録情報が格納されたDeptオブジェクト。
     * @return integer 登録情報の連番主キーの値。登録に失敗した場合は-1。
     */
    public function insert(Dept $dept): int
    {
        $sqlInsert = "INSERT INTO depts (dp_no, dp_name, dp_loc) VALUES (:dp_no,
:dp_name, :dp_loc)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":dp_no", $dept->getDpNo(), PDO::PARAM_INT);
        $stmt->bindValue(":dp_name", $dept->getDpName(), PDO::PARAM_STR);
        $stmt->bindValue(":dp_loc", $dept->getDpLoc(), PDO::PARAM_STR);
        $result = $stmt->execute();
        if ($result) {
            $dpId = $this->db->lastInsertId();
        } else {
            $dpId = -1;
        }
        return  $dpId;
    }

    /**
     * 部門情報更新。更新対象は1レコードのみ。
     *
     * @param Dept $dept
     * 更新情報が格納されたDeptオブジェクト。主キーがこのオブジェクトのidの値のレコードを更新する。
     * @return boolean 登録が成功したかどうかを表す値。
     */
    public function update(Dept $dept): bool
    {
        $sqlUpdate = "UPDATE depts SET dp_no = :dp_no, dp_name = :dp_name, dp_loc =:dp_loc WHERE id = :id";
        $stmt = $this->db->prepare($sqlUpdate);
        $stmt->bindValue(":dp_no", $dept->getDpNo(), PDO::PARAM_INT);
        $stmt->bindValue(":dp_name", $dept->getDpName(), PDO::PARAM_STR);
        $stmt->bindValue(":dp_loc", $dept->getDpLoc(), PDO::PARAM_STR);
        $stmt->bindValue(":id", $dept->getId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * 部門情報削除。削除対象は1レコードのみ。
     *
     * @param integer $id 削除対象の主キー。
     * @return boolean 登録が成功したかどうかを表す値。
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM depts WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}