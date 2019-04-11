<?

namespace Domain\Customer\Contracts;

/**
 * Description of CustomerCriteriaInterface
 *
 * @author Admin
 */
interface CustomerCriteriaInterface
{
    /**
     * @return int|null
     */
    public function getRows();

    
    /**
     * @return int|null
     */
    public function getPage();

    /**
     * @return string|null
     */
    public function getFindById();
    
    /**
     * @return string|null
     */
    public function getFindByName();
}