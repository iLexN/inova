<?php

namespace App\Helper;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as Paginate;
use Illuminate\Contracts\Pagination\Paginator as SimplePaginate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use Psr\Container\ContainerInterface;

class Pagination
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public $item_pre_page = 15;

    private $page = 1;

    private $pageMode = 1;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param int $item_pre_page
     */
    public function setItemPrePage(int $item_pre_page)
    {
        $this->item_pre_page = $item_pre_page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page)
    {
        $this->page = $page;
        Paginator::currentPageResolver(function() use ($page) {
            return $page;
        });
    }

    /**
     * @param Builder $q
     * @return Paginate|SimplePaginate|Collection
     */
    public function getPageMode(Builder $q)
    {
        switch ($this->pageMode) {
            case 1:
                return $q->simplePaginate($this->item_pre_page);
            case 2:
                return $q->paginate($this->item_pre_page);
            default:
                return $q->forPage($this->page, $this->item_pre_page)->get();
        }
    }

    /**
     * @param int $pageMode
     */
    public function setPageMode(int $pageMode)
    {
        $this->pageMode = $pageMode;
    }
}
