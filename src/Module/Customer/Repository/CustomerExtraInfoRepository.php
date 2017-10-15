<?php

namespace App\Module\Customer\Repository;

use App\Module\Customer\Entity\CustomerExtraInfo;

/**
 * Class CustomerExtraInfoRepository
 *
 * @package App\Module\Customer\Repository
 */
class CustomerExtraInfoRepository
{

    /**
     * Create customer extra info
     *
     * @param array $data
     *
     * @return CustomerExtraInfo
     */
    public function create(array $data)
    {
        return CustomerExtraInfo::create($data);
    }

    /**
     * Find customer extra info by id
     *
     * @param int $id
     *
     * @return CustomerExtraInfo|null
     */
    public function findOne(int $id)
    {
        return CustomerExtraInfo::find($id);
    }

    /**
     * delete customer extra info
     *
     * @param int $id
     */
    public function delete(int $id)
    {
        CustomerExtraInfo::destroy($id);
    }
}
