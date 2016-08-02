<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.07.2015
 * Time: 19:28
 */

namespace Admin\MembersBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class VerificationStatusColumn
 * @package Admin\MembersBundle\Grid\Column
 */
class VerificationStatusColumn extends Column
{
//    /**
//     * @param array $params
//     */
//    public function __initialize(array $params)
//    {
//        parent::__initialize($params);
//
//        // Disable the filter of the column
////        $this->setFilterable(true);
//        $this->setOrder(false);
//    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'verification_status_column';
    }
}