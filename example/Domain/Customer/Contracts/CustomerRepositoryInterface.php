<?

namespace Domain\Customer\Contracts;

/**
 * Description of CustomerRepositoryInterface
 *
 * @author Admin
 */
interface CustomerRepositoryInterface
{
    
    public function findByCriteria(CustomerCriteriaInterface $criteria): \Domain\Customer\CustomerCollection;
    
    public function save(\Domain\Customer\Customer $customer);
    
    public function delete(\Domain\Customer\Customer $customer);
    
    public function findById(int $id):?\Domain\Customer\Customer;
    
}