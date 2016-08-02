<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 23.03.16
 * Time: 17:12
 */

namespace Admin\SettingsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class FileManagerController
 * @package Admin\SettingsBundle\Controller
 */
class FileManagerController extends Controller
{
    /**
     * @return array
     *
     * @Route("/file-manager", name="settings_file_manager")
     * @Template("AdminSettingsBundle:FileManager:file_manager.html.twig")
     */
    public function fileManagerAction()
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem($this->get('translator')->trans('settings.file_manager.file_manager'), $this->get("router")->generate('settings_file_manager'));

        return array();
    }
}
