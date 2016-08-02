<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class BackKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Admin\UserBundle\AdminUserBundle(),
            new Admin\DashBoardBundle\AdminDashBoardBundle(),
            new Admin\MembersBundle\AdminMembersBundle(),
            new UserBundle\UserBundle(),
            new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),
            new APY\DataGridBundle\APYDataGridBundle(),
            new Admin\SettingsBundle\AdminSettingsBundle(),
            new Admin\SupportBundle\AdminSupportBundle(),
            new SupportBundle\SupportBundle(),
            new Admin\StaticPageBundle\AdminStaticPageBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new WalletBundle\WalletBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new MarketingBundle\MarketingBundle(),
            new Admin\MarketingBundle\AdminMarketingBundle(),
            new StatisticBundle\StatisticBundle(),
            new Admin\CreditBundle\AdminCreditBundle(),
            new Admin\WalletBundle\AdminWalletBundle(),
            new Admin\NewsBundle\AdminNewsBundle(),
            new CareerBundle\CareerBundle(),
            new Admin\CareerBundle\AdminCareerBundle(),
            new Admin\FaqBundle\AdminFaqBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
