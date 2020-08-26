<?php

/**
 * PH34 サンプル2 マスタテーブル管理 Src05/12
 * @author Ando Takashi
 *
 * ファイル名=Dept.php
 * ディレクトリ=/ph34/scottadmindao/classes/entity/
 */

/**
 * 部門エンティティクラス。
 */
class Dept
{
    /**
     * ID。
     */
    private $id;
    /**
     * 部門番号。
     */
    private $dpNo;
    /**
     * 部門名。
     */
    private $dpName;
    /**
     * 所在地
     */
    private $dpLoc;

    //以下アクセサメソッド。

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getDpNo(): ?int
    {
        return $this->dpNo;
    }
    public function setDpNo(int $dpNo): void
    {
        $this->dpNo = $dpNo;
    }
    public function getDpName(): ?string
    {
        return $this->dpName;
    }
    public function setDpName(string $dpName): void
    {
        $this->dpName = $dpName;
    }
    public function getDpLoc(): ?string
    {
        return $this->dpLoc;
    }
    public function setDpLoc(?string $dpLoc): void
    {
        $this->dpLoc = $dpLoc;
    }
}
