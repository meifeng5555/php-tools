<?php

/**
 * Class    Duplicate
 * @desc    数据去重类
 *              通过 偏移量+取余（位运算）
 *              理论上最大可优化内存 PHP_INT_SIZE * 8 倍内存
 *
 * @author  meijinfeng
 */
class Duplicate
{
    /**
     * @var string
     */
    private $lastError;

    /**
     * @var array
     */
    private $bitArray = [];

    /**
     * @var int
     */
    private static $byteBits = 8;

    /**
     * @var int
     */
    private $bitArrayElementSize;

    public function __construct()
    {
        $this->setOptimalBitArrayElementSize();
    }

    private function setOptimalBitArrayElementSize(): void
    {
        $this->bitArrayElementSize = PHP_INT_SIZE * self::$byteBits;
    }

    /**
     * Add source to BitArray
     *
     * @param int $source
     * @return bool
     */
    public function add(int $source): bool
    {
        $offset = floor($source / $this->bitArrayElementSize);
        $mod = $source % $this->bitArrayElementSize;
        $modDecimal = 1 << $mod;

        try {

            $baseVal = $this->bitArray[$offset] ?? 0;
            ($baseVal & $modDecimal) > 0 ?: $this->bitArray[$offset] = $baseVal | $modDecimal;
            return true;
        } catch (Exception $exception) {

            $this->lastError = $exception->getMessage();
            return false;
        }
    }

    /**
     * Is source exist in this BitArray
     *
     * @param int $source
     * @return bool
     */
    public function exist(int $source): bool
    {
        $offset = floor($source / $this->bitArrayElementSize);
        $mod = $source % $this->bitArrayElementSize;
        $modDecimal = 1 << $mod;

        $baseVal = $this->bitArray[$offset] ?? 0;
        return boolval($baseVal & $modDecimal);
    }

    public function getLastError(): string
    {
        return $this->lastError;
    }
}