<?

namespace Aplication;

/**
 * Description of Home
 *
 * @author Admin
 */
class Home
{
    protected $repo;
            
    function __construct(\Domain\Customer\Contracts\CustomerRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }


    public function index(){
        
        $criteria = new \Infrastructure\Customer\CustomerCriteria();
        $criteria
                ->setRows(10)
                ->setFindByName("Vova")
                ;
        
        $customers = $this->repo->findByCriteria($criteria);
    }
    
}