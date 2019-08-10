<?php 
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BooleanExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('display_boolean', [$this, 'displayBoolean']),
        ];
    }

    public function displayBoolean($entity)
    {
        $response = '';
        switch ($entity) {
            case 1:
                $response = 'oui';
                break;
            case 0:
                $response =  'non';
                break;
        }
        return $response;
    }
}
