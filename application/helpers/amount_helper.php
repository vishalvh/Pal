<?php 
if(!function_exists('amountfun'))
{
    function amountfun($amount)
    {
	   setlocale(LC_MONETARY, 'en_IN');
	   return money_format('%!i', $amount);
    }
}
?>