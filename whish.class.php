<?php


class whish
{
    private $database;

    public function __construct($database)
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(!isset($_SESSION['whish']))
        {
            $_SESSION['whish'] = array();
        }
        $this->database = $database;
    }

    public function total()
    {
        $total = 0;
        $ids = array_keys($_SESSION['whish']);

        if(empty($ids))
        {
            $products = array();
        }
        else{

            $products = $this->database->query('SELECT * FROM items WHERE id IN ('.implode(',',$ids).')');
        }
        foreach($products as $product)
        {
            $total += $product->price * $_SESSION['whish'][$product->id];
        }

        return $total;
    }

    public function add($product_id)
    {
        if(isset($_SESSION['whish'][$product_id]))
        {
            $_SESSION['whish'][$product_id]++;
        }
        else
        {
            $_SESSION['whish'][$product_id] = 1;
        }

    }

    public function del($product_id)
    {
        unset($_SESSION['whish'][$product_id]);
    }

    public function count()
    {
        return array_sum($_SESSION['whish']);
    }


}
