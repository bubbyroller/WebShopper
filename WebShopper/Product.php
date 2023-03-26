<?php



class Product
{

    //Variables and constants
    private $id;
    private $name;
    private $price;
    private $offer;
    private static $count = 0;


    //Constructor
    function __construct($id, $name, $price, $offer = "normal")
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->offer = $offer;
    }

    //Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getOffer()
    {
        return $this->offer;
    }

    public function getCount()
    {
        return self::$count;
    }

    //Setters
    public function setCount($count)
    {
        self::$count = $count;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setOffer($offer)
    {
        $this->offer = $offer;
    }

    // Class methods

}
