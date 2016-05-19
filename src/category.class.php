<?php
// Categories
class Category
{
    private $cid;
    private $cname;

    public function __construct() {}

    //!\\ Must remake this method with an array in parameters
    public function hydrate($n, $i=0)
    {
        $this->cid = $i;
        $this->cname = $n;
    }

    public function getCid()
    {
        return $this->cid;
    }

    public function setCid($newcid)
    {
        $newcid = (int) $newcid;
        
        // Verifying that cid isn't negative
        if ($newcid >= 0)
        {
            $this->cid = $newcid;
        }
    }

    public function getCname()
    {
        return $this->cname;
    }

    public function setCname($newName)
    {
        $this->cname = $newName;
    }
}
?>
