<?php
/**
 * Created by PhpStorm.
 * User: Yu-Hsien Chou
 * Date: 2019/2/21
 * Time: 下午 10:22
 */

namespace YuHsien\QwanInterviewShoppingcart\Exceptions;


use Throwable;

class ShoppingCartImportException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}