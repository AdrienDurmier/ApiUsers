<?php

namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Tiers\Contact;
use App\Entity\Tiers\Client;
use App\Entity\Tiers\Site;

/**
 * Class ContactImportCommand
 * @package App\ConsoleCommand
 */
class ContactImportCommand extends Command
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
            ->setName('import:contact')
            ->setDescription('Import des contacts des fiches tiers de Consonnance Web.')
        ;
    }

    /**
     * A importer après les sites
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
        $io->title('Import des contacts à partir du fichier csv extrait de Consonnace Web...');

        // enregistrer en csv + garder la marge uniquement (supprimer les 2 première lignes) + convertir en UTF-8 avec BOM via notepad
        $csv = Reader::createFromPath('%kernel.root_dir%/../src/Data/contacts.csv'); 
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
        
        // /!\ il n'y a pas d'identifiant dans les csv de Consonance Web
        // 1. suppression de tous les contacts
        $contacts = $this->em->getRepository(Contact::class)->findAll();
        foreach ($contacts as $contact) {
            $this->em->remove($contact);
        }
        $this->em->flush();
        
        // 2. ajout de tous les contacts
        foreach ($results as $row) {
            // dump($row);die();
            $contact = new Contact();
            $contact->setFirstname($row['Prénom']);
            $contact->setLastname($row['Nom']);
            $contact->setTelephone($row['Telephone']);
            $contact->setMobile($row['Portable']);
            $contact->setEmail($row['Email']);
            $contact->setFonction($row['Fonction']);

            // Lien avec le site
            $site = $this->em->getRepository(Site::class)->findOneBy([
                'societe'   =>  $row['Site']
            ]);
            $contact->setSite($site);

            // Lien avec le client
            $client = $this->em->getRepository(Client::class)->findOneBy([
                'societe'   =>  $row['Nom tiers']
            ]);
            $contact->setClient($client);
            
            $this->em->persist($contact);
            $io->progressAdvance();
        }

        $this->em->flush();

        $io->progressFinish();
        $io->success('Fichier importé avec succès');
    }
}