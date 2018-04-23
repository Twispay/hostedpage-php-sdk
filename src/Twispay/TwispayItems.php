<?php

namespace Twispay;

/**
 * Class TwispayItems
 *
 * @package Twispay
 * @author Dragos URSU
 * @version GIT: $Id:$
 */
class TwispayItems implements \ArrayAccess, \Iterator, \Countable
{
    /** @var TwispayItem[] $list */
    protected $list = [];

    /**
     * Method offsetSet
     *
     * @param int $offset
     * @param TwispayItem $value
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->list[] = $value;
        } else {
            $this->list[$offset] = $value;
        }
    }

    /**
     * Method offsetExists
     *
     * @param int $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->list[$offset]);
    }

    /**
     * Method offsetUnset
     *
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->list[$offset]);
    }

    /**
     * Method offsetGet
     *
     * @param int $offset
     *
     * @return TwispayItem|null
     */
    public function offsetGet($offset)
    {
        return isset($this->list[$offset]) ? $this->list[$offset] : null;
    }

    /**
     * Method rewind
     */
    public function rewind()
    {
        reset($this->list);
    }

    /**
     * Method current
     *
     * @return TwispayItem
     */
    public function current()
    {
        return current($this->list);
    }

    /**
     * Method key
     *
     * @return int
     */
    public function key()
    {
        return key($this->list);
    }

    /**
     * Method next
     */
    public function next()
    {
        next($this->list);
    }

    /**
     * Method valid
     *
     * @return bool
     */
    public function valid()
    {
        $key = key($this->list);
        return (!is_null($key) && ($key !== false));
    }

    /**
     * Method count
     *
     * @return int
     */
    public function count()
    {
        return count($this->list);
    }

    /**
     * Method toArray
     *
     * @return array
     */
    public function toArray()
    {
        $list = [];
        foreach ($this->list as $twispayItem) {
            $data = $twispayItem->toArray();
            foreach ($data as $key => $value) {
                if (!isset($list[$key])) {
                    $list[$key] = [];
                }
                $list[$key][] = $value;
            }
        }
        return $list;
    }

    /**
     * Method getAmount
     *
     * @return float
     */
    public function getAmount()
    {
        $amount = 0.0;
        foreach ($this->list as $twispayItem) {
            $amount += (float)$twispayItem->getUnitPrice() * (float)$twispayItem->getUnits();
        }
        return $amount;
    }

    /**
     * Method validate
     *
     * @throws TwispayException
     */
    public function validate() {
        foreach ($this->list as $twispayItem) {
            $twispayItem->validate();
        }
    }
}
