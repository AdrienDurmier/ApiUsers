<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Tiers\Site;
use App\Entity\Tiers\Client;

/**
 * Class SiteImportCommand
 * @package App\ConsoleCommand
 */
class SiteImportCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CsvImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    /**
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('import:site')
            ->setDescription('Import des sites des fiches tiers de Consonnance Web.')
        ;
    }

    /**
     * A importer après les clients
     * 
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import des sites à partir du fichier csv extrait de Consonnace Web...');

        // enregistrer en csv + garder la marge uniquement (supprimer les 2 première lignes) + convertir en UTF-8 avec BOM via notepad
        $csv = Reader::createFromPath('%kernel.root_dir%/../src/Data/sites.csv'); 
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $input_bom = $csv->getInputBOM();
        if ($input_bom === Reader::BOM_UTF16_LE || $input_bom === Reader::BOM_UTF16_BE) {
            $csv->addStreamFilter('convert.iconv.UTF-16/UTF-8');
        }

        $results = $csv->getRecords();

        $count = 0;
        foreach ($results as $row) {
            $count++;
        }

        $io->progressStart($count);
        
        // /!\ il n'y a pas d'identifiant dans les csv de Consonance Web pour le moment (demande faite à Alban le 23/07/2019)

        // 1. suppression de tous les sites
        $sites = $this->em->getRepository(Site::class)->findAll();
        foreach ($sites as $site) {
            $this->em->remove($site);
        }
        $this->em->flush();

        // 2. ajout de tous les sites
        foreach ($results as $row) {

            // dump($row);die();

            $site = new Site();
            $site->setSociete($row['Site']);
            $site->setAdresse($row['Adresse']);
            $site->setCodePostal($row['CP']);
            $site->setVille($row['Ville']);
            $site->setSiret($row['SIRET']);

            $client = $this->em->getRepository(Client::class)->findOneBy([
                'societe'   =>  $row['Nom tiers']
            ]);
            $site->setClient($client);
            
            $this->em->persist($site);

            $io->progressAdvance();
        }

        $this->em->flush();

        $io->progressFinish();
        $io->success('Fichier importé avec succès');
    }
}