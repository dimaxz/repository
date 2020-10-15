<?php

namespace Repo\Concrete;

use Repo\PaginationInterface;
use Repo\RepositoryCriteriaInterface;

abstract class AbstractCriteria implements PaginationInterface, RepositoryCriteriaInterface
{

    protected $limit;
    protected $page = 1;
    private $def = 50;

    abstract public static function create();

    /**
     * @var array|null
     */
    protected $filterByIds;

    /**
     * @var int|null
     */
    protected $filterById;

    /**
     * @var string|null
     */
    protected $sortById;

    /**
     * @return array|null
     */
    public function getFilterByIds(): ?array
    {

        return $this->filterByIds;
    }

    /**
     * @param array|null $filterByIds
     *
     * @return AbstractCriteria
     */
    public function setFilterByIds(?array $filterByIds): AbstractCriteria
    {

        $this->filterByIds = $filterByIds;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getFilterById(): ?int
    {

        return $this->filterById;
    }

    /**
     * @param int|null $filterById
     *
     * @return $this
     */
    public function setFilterById(?int $filterById)
    {

        $this->filterById = $filterById;

        return $this;
    }

    public function filterById(?int $id)
    {

        $this->filterById = $filterById;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSortById(): ?string
    {

        return $this->sortById;
    }

    /**
     * @param string|null $sortById
     *
     * @return AbstractCriteria
     */
    public function setSortById(?string $sortById): AbstractCriteria
    {

        $this->sortById = $sortById;

        return $this;
    }


    public function sortById(?string $sort)
    {
        $this->sortById = $sortById;

        return $this;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {

        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {

        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return AbstractCriteria
     */
    public function setLimit(int $limit): AbstractCriteria
    {

        $this->limit = $limit;

        return $this;
    }

    /**
     * @param int $page
     *
     * @return AbstractCriteria
     */
    public function setPage(int $page): AbstractCriteria
    {

        $this->page = $page;

        return $this;
    }

    public function getDefaultLimit(): int
    {

        return $this->def;
    }

    public function setDefaultLimit($limit)
    {

        $this->def = $limit;

        return $this;
    }


}