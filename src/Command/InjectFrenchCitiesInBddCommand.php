<?php

namespace App\Command;

use App\Entity\City;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class InjectFrenchCitiesInBddCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:inject-french-cities-in-bdd';

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Inject french cities in table City')
            ->setHelp('This command allow you to inject french cities from csv to table city in database.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws Exception
     * @throws ORMException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* @var $em EntityManager */
        $em = $this->container->get('doctrine.orm.entity_manager');

        //change la limite de la mémoire juste pour l'execution de la commande
        ini_set("memory_limit", "-1");

        $connection = $em->getConnection();

        //if needed, purged city table
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 0'); //to avoid bdd foreign keys verifications
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('city'));
        $connection->executeQuery('SET FOREIGN_KEY_CHECKS = 1');

        //get csv
        $csv = dirname($this->container->get('kernel')->getProjectDir()). DIRECTORY_SEPARATOR . 'deliveroo_like' . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'cities.csv';
//        $output->writeln($csv);
        $lines = explode("\n", file_get_contents($csv));
        $cities = [];

        foreach($lines as $k => $line){
            $line = explode(';', $line);
            if(count($line) > 10 && $k > 0){
                $city = new City();
                $city->setName($line[8]);
                $city->setZipCode($line[9]);
                $cities[] = $line[8];
                $em->persist($city);
            }
        }
        $em->flush();
        $output->writeln(count($cities) . ' Villes importées');
    }

}
