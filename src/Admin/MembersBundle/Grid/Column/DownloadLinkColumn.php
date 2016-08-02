<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.07.2015
 * Time: 19:47
 */

namespace Admin\MembersBundle\Grid\Column;

use APY\DataGridBundle\Grid\Column\Column;

/**
 * Class DownloadLinkColumn
 * @package Admin\MembersBundle\Grid\Column
 */
class DownloadLinkColumn extends Column
{
    /**
     * @param array $params
     */
    public function __initialize(array $params)
    {
        parent::__initialize($params);

        // Disable the filter of the column
        $this->setFilterable(false);
        $this->setOrder(false);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return 'download_link_column';
    }
}