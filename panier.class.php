<?php


class panier
{
    private $database;

    public function __construct($database)
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(!isset($_SESSION['panier']))
        {
            $_SESSION['panier'] = array();
        }
        $this->database = $database;
    }

    public function total()
    {
        $total = 0;
        $ids = array_keys($_SESSION['panier']);

        if(empty($ids))
        {
            $products = array();
        }
        else{

            $products = $this->database->query('SELECT * FROM items WHERE id IN ('.implode(',',$ids).')');
        }
        foreach($products as $product)
        {
            $total += $product->price * $_SESSION['panier'][$product->id];
        }

        return $total;
    }

    public function add($product_id)
    {
        if(isset($_SESSION['panier'][$product_id]))
        {
            $_SESSION['panier'][$product_id]++;
        }
        else
        {
            $_SESSION['panier'][$product_id] = 1;
        }

    }

    public function del($product_id)
    {
        unset($_SESSION['panier'][$product_id]);
    }

    public function count()
    {
        return array_sum($_SESSION['panier']);
    }


}
