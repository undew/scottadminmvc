<?php

/**
 * PH34 サンプル2 マスタテーブル管理 Src05/12
 * @author Ando Takashi
 *
 * ファイル名=Em.php
 * ディレクトリ=/ph34/scottadmindao/classes/entity/
 */

/**
 * 部門エンティティクラス。
 */
class Emp
{
    /**
     * ID。
     */
    private $id;
    /**
     * 従業員番号。
     */
    private $emNo;
    /**
     * 従業員名。
     */
    private $emName;
    /**
     * 部門番号。
     */
    private $emJob;
    /**
     * 部門名。
     */
    private $emMgr;
    /**
     * 所在地。
     */
    private $emHiredate;
    /**
     * 給料。
     */
    private $emSal;
    /**
     * 部門番号。
     */
    private $deptId;

    //以下アクセサメソッド。

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getEmNo(): ?int
    {
        return $this->emNo;
    }
    public function setEmNo(int $emNo): void
    {
        $this->emNo = $emNo;
    }
    public function getEmName(): ?string
    {
        return $this->emName;
    }
    public function setEmName(string $emName): void
    {
        $this->emName = $emName;
    }
    public function getEmJob(): ?string
    {
        return $this->emJob;
    }
    public function setEmJob(string $emJob): void
    {
        $this->emJob = $emJob;
    }
    public function getEmMgr(): ?int
    {
        return $this->emMgr;
    }
    public function setEmMgr(int $emMgr): void
    {
        $this->emMgr = $emMgr;
    }
    public function getEmHiredate(): ?string
    {
        return $this->emHiredate;
    }
    public function setEmHiredate(?string $emHiredate): void
    {
        $this->emHiredate = $emHiredate;
    }
    public function getEmSal(): ?int
    {
        return $this->emSal;
    }
    public function setEmSal(?int $emSal): void
    {
        $this->emSal = $emSal;
    }
    public function getDeptId(): ?int
    {
        return $this->deptId;
    }
    public function setDeptId(?int $deptId): void
    {
        $this->deptId = $deptId;
    }
}