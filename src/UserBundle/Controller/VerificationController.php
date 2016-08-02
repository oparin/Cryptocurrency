<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 02.07.2015
 * Time: 14:37
 */

namespace UserBundle\Controller;

use Doctrine\ORM\EntityManager;
use UserBundle\Entity\User;
use UserBundle\Entity\Verification;
use UserBundle\Form\Type\VerificationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VerificationController
 * @package UserBundle\Controller
 */
class VerificationController extends Controller
{
    /**
     * @param Request $request
     * @return array
     *
     * @Route("/verification", name="user_verification")
     * @Template("UserBundle:Verification:verification.html.twig")
     */
    public function verificationAction(Request $request)
    {
        $user = $this->getUser();

        if ($request->isMethod('POST')) {
                $em = $this->getDoctrine()->getManager();
                $user->setVerificationStatus(1);
                $em->flush();

                return $this->redirect($this->generateUrl('user_verification'));
        }

        return array();
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/upload-file", name="user_upload_file")
     */
    public function uploadFileAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();

        $ret = array();

        if (isset($_FILES["passportPhotoName"])) {
            $outputDir = 'uploads/verification/';
            $fileName = uniqid().'_'.$_FILES["passportPhotoName"]["name"];
            $nameArray = explode('.', $fileName);
            if (in_array($nameArray[count($nameArray) - 1], array('jpeg', 'jpg', 'png', 'gif', 'pdf', 'JPEG', 'JPG', 'PNG', 'GIF', 'PDF'))) {
                if (move_uploaded_file($_FILES["passportPhotoName"]["tmp_name"], $outputDir.$fileName)) {
                    $ret[] = $fileName;

                    /** @var $user User */
                    $user = $this->getUser();
                    $verification = $user->getVerification();

                    if ($verification) {
                        if ($verification->getPassportPhotoName()) {
                            if (file_exists($outputDir.$verification->getPassportPhotoName())) {
                                unlink($outputDir.$verification->getPassportPhotoName());
                            }
                        }
                    } else {
                        $verification = new Verification();
                    }
                    $verification->setPassportPhotoName($fileName);
                    $verification->setUpdatedAt(new \DateTime());
                    $em->persist($verification);
                    $user->setVerification($verification);
                    $user->setVerificationStatus(0);
                    $em->flush();

//                    chmod($outputDir.$verification->getPassportPhotoName(), 777);
                } else {
                    $ret['jquery-upload-file-error'] = "Not move!";
                }
            } else {
                $ret['jquery-upload-file-error'] = "Wrong Extension!";
            }
        }

        return new Response(json_encode($ret));
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/delete-file", name="user_delete_file")
     */
    public function deleteFileAction(Request $request)
    {
        if ($request->request->get('op') && $request->request->get('name')) {
            /** @var $em EntityManager */
            $em = $this->getDoctrine()->getManager();

            switch ($request->request->get('op')) {
                case 'passportPhotoName':
                    $fileName   = json_decode($request->request->get('name'));
                    $fileName   = str_replace("..", ".", $fileName[0]);
                    $outputDir  = 'uploads/verification/';
                    $filePath   = $outputDir.$fileName;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        /** @var $user User */
                        $user = $this->getUser();
                        $verification = $user->getVerification();
                        $verification->setPassportPhotoName(null);
                        $user->setVerificationStatus(0);
                        $em->flush();

                        return new Response("Deleted File ".$fileName);
                    }
                    break;
                default:
                    break;
            }

            return new Response("File not delete!");
        }

        return new Response("Wrong parameters!");
    }
}