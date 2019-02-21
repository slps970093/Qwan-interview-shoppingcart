<?php
/**
 * Created by PhpStorm.
 * User: Yu-Hsien Chou
 * Date: 2019/2/21
 * Time: 下午 09:23
 */

namespace YuHsien\QwanInterviewShoppingcart;


use YuHsien\QwanInterviewShoppingcart\Exceptions\ShoppingCartImportException;
use YuHsien\QwanInterviewShoppingcart\Exceptions\ShoppingCartItemException;

class ShoppingCart
{

    const productName = 'name';
    const price = 'price';
    const qty = 'qty';
    const other = 'other';

    private $cart;


    public function import( $item ){
        if( !is_array($item) ){
            throw new ShoppingCartImportException('import data datatype is not array');
        }
        foreach ( $item as $value ){
            if ( empty($value[ self::productName]) || !is_numeric($value[ self::qty]) || !is_numeric($value[ self::price]) ) {
                throw new ShoppingCartImportException('data formet error');
            }
            if ( is_string($value[ self::other]) || is_array( $value[ self::other]) ){
                $this->cart[] = array (
                    self::productName => $value[ self::productName ],
                    self::price => $value[ self::price ],
                    self::qty => $value[ self::qty ],
                    self::other => $value[ self::other ]
                );
            }else {
                $this->cart[] = array (
                    self::productName => $value[ self::productName ],
                    self::price => $value[ self::price ],
                    self::qty => $value[ self::qty ]
                );
            }
        }


    }

    public function getCartItems(){
        return $this->cart;
    }

    /**
     * 新增購物車
     * @param $name
     * @param int $price
     * @param int $qty
     * @param null $other
     * @throws ShoppingCartItemException
     */
    public function append ( $name , $price = 0 , $qty = 0 , $other = null ){
        if ( is_numeric($price) && is_numeric($qty) && !empty($name) ) {
            if ( is_string($other) || is_array($other) ){
                $this->cart[] = array (
                    self::productName => $name,
                    self::price => $price,
                    self::qty => $qty,
                    self::other => $other
                );
            }else {
                $this->cart[] = array (
                    self::productName => $name,
                    self::price => $price,
                    self::qty => $qty
                );
            }

        } else {
            throw new ShoppingCartItemException("prodect append error");
        }
    }

    /**
     * 更新購物車
     * @param $index
     * @param $name
     * @param int $price
     * @param int $qty
     * @param null $other
     * @throws ShoppingCartItemException
     */
    public function modify( $index , $name , $price = 0 , $qty = 0 , $other = null ) {
        if ( is_numeric($index) && is_numeric($price) && is_numeric($qty) && !empty($name) ) {
            if ( is_string($other) || is_array($other) ){
                $this->cart[$index] = array (
                    self::productName => $name,
                    self::price => $price,
                    self::qty => $qty,
                    self::other => $other
                );
            } else {
                $this->cart[$index] = array (
                    self::productName => $name,
                    self::price => $price,
                    self::qty => $qty
                );
            }
        } else {
            throw new ShoppingCartItemException("modify product error");
        }
    }


    /**
     * 刪除購物車項目
     * @param $index
     * @throws ShoppingCartItemException
     */
    public function remove ( $index ){
        if ( !array_key_exists($index,$this->cart) ){
            throw new ShoppingCartItemException('not found product');
        }
        unset($this->cart[$index]);
    }

    /**
     * 取得總金額
     * @return float|int
     */
    public function getTotalPrice () {
        $totalPrice = 0;
        foreach ($this->cart as $item) {
            $totalPrice += $item[ self::qty ] * $item[ self::price ];
        }
        return $totalPrice;
    }

    /**
     * 取得購物車數量
     * @return int
     */
    public function getCount () {
        return count($this->cart);
    }

}