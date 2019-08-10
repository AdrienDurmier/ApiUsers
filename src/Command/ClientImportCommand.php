<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Tiers\Client;

/**
 * Class ClientImportCommand
 * @package App\ConsoleCommand
 */
class ClientImportCommand extends Command
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
            ->setName('import:client')
            ->setDescription('Import des fiches tiers de Consonnance Web.')
        ;
    }

    /**
     * A importer en premier
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
        $io->title('Import des clients à partir du fichier csv extrait de Consonnace Web...');

        $csv = Reader::createFromPath('%kernel.root_dir%/../src/Data/tiers.csv'); // Garder la marge et encoder en UTF-8 avec BOM via notepad
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
        
        foreach ($results as $row) {
            //dump($row);die();

            // Si l'identifiant de consonnance web correspond à un client dans Heidi alors il doit être modifier
            $client = $this->em->getRepository(Client::class)->findOneBy([
                'id_cweb'   =>  $row['Identifiant tiers']
            ]);
            if($client === null){
                // Si l'identifiant de consonnance web ne correspond pas a un client dans Heidi alors il doit être créer
                $client = new Client();
            }
            $client->setSociete($row['Nom / Raison sociale']);
            $client->setCategorie($row['Type']);
            $client->setAdresse($row['Adresse']);
            $client->setSiret($row['SIRET']);
            $client->setNaf($row['Code APE']);
            $client->setCodePostal($row['CP']);
            $client->setVille($row['Ville']);
            $client->setIdCweb($row['Identifiant tiers']);
            $this->em->persist($client);

            $io->progressAdvance();
        }

        $this->em->flush();

        $io->progressFinish();
        $io->success('Fichier importé avec succès');
    }
}