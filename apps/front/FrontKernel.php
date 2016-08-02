<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class FrontKernel extends Kernel
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
            new HomeBundle\HomeBundle(),
            new UserBundle\UserBundle(),
            new SupportBundle\SupportBundle(),
            new OfficeBundle\OfficeBundle(),
            new Admin\StaticPageBundle\AdminStaticPageBundle(),
            new WalletBundle\WalletBundle(),
            new MarketingBundle\MarketingBundle(),
            new Admin\SettingsBundle\AdminSettingsBundle(),
            new Admin\MarketingBundle\AdminMarketingBundle(),
            new StatisticBundle\StatisticBundle(),
            new APY\DataGridBundle\APYDataGridBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Admin\CreditBundle\AdminCreditBundle(),
            new CareerBundle\CareerBundle(),
            new Admin\CareerBundle\AdminCareerBundle(),
//            new Vich\UploaderBundle\VichUploaderBundle(),
            new Admin\NewsBundle\AdminNewsBundle(),
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
