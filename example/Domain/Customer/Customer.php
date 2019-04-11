<?

namespace Domain\Customer;

/**
* Description of Customer
*
* @author Admin
*/
class Customer
{

    /**
     *
     * @var int
     */
    protected $id;
    
    /**
     *
     * @var string
     */
    protected $name;
    
    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}