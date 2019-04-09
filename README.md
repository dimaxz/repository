# Repository
интерфейсы для работы с репозиториями

## Выборка одной записи
```php
<?php
$userRepository = new UserRepository;

$criteria = new UserCriteria();
$criteria->setFilterById(1);

$user = $userRepository->findByCriteria($criteria)->current();

//или

$user = $userRepository->findById(1);
```

## Выборка записей с фильтрацией
```php
<?php
$userRepository = new UserRepository;

$criteria = new UserCriteria();
$criteria->setFilterByName("Vova");

$users = $userRepository->findByCriteria($criteria);
```

## Пример реализации интерфейсов
```php
<?php
class UserRepository implements CrudRepositoryInterface
{
	protected $data = [
		[
			"id"	=>	1,
			"name"	=>	"Vova"	
		],
		[
			"id"	=>	2,
			"name"	=>	"Petia"	
		]		
	];
	
	public function findByCriteria(RepositoryCriteriaInterface $criteria): CollectionInterface{
		
		$collection = new UserCollection;
		
		foreach($this->data as $row){
			
			$user = (new User)->setId($row["id"])->setName($row["name"]);
			
			//фильтруем по id
			if($criteria->getFilterByid()!==null && $criteria->getFilterByid() != $user->getId()){
				continue;
			}
			
			$collection->add($user);
		}
		
		return $collection;
	}
	
	public function findById(int $id) :? EntityInterface{
		$criteria = new UserCriteria();
		$criteria->setFilterById($id);
        
		$user = $this->findByCriteria($criteria)->current();
        
		return is_object($user) ? $user : null;
	}
}


class User implements EntityInterface{
	
	protected $id;
	protected $name;
	
	public function getId():?int{
		return $this->id;
	}
	
	public function getName():?string{
		return $this->name;
	}
	
	public function setId(?int $id){
		$this->id = $id;
		return $this;
	}
	
	public function setName(?string $name){
		$this->id = $name;
		return $this;
	}
	
}

class UserCollection implements CollectionInterface{
	
	public function getClassName():string{
		return User::class;
	} 
}
````

