<?

namespace Infrastructure\Customer;

/**
 * Description of CustomerRepositiry
 *
 * @author Admin
 */
class CustomerRepositiry implements \Domain\Customer\Contracts\CustomerRepositoryInterface
{
    
    
    public function delete(\Domain\Customer\Customer $customer)
    {
        
    }

    public function findByCriteria(\Domain\Customer\Contracts\CustomerCriteriaInterface $criteria): \Domain\Customer\CustomerCollection
    {
        
    }

    public function findById(int $id): ?\Domain\Customer\Customer
    {
        
    }

    public function save(\Domain\Customer\Customer $customer)
    {
        
    }


}