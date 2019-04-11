<?

namespace Infrastructure\Customer;

/**
 * Description of CustomerCriteria
 *
 * @author Admin
 */
class CustomerCriteria implements \Domain\Customer\Contracts\CustomerCriteriaInterface
{
    
    protected $findById;
    protected $findByName;
    protected $page;
    protected $rows;

    function getFindById()
    {
        return $this->findById;
    }

    function getFindByName()
    {
        return $this->findByName;
    }

    function getPage()
    {
        return $this->page;
    }

    function getRows()
    {
        return $this->rows;
    }

    function setFindById($findById)
    {
        $this->findById = $findById;
        return $this;
    }

    function setFindByName($findByName)
    {
        $this->findByName = $findByName;
        return $this;
    }

    function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }


}