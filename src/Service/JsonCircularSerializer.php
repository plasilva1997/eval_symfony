<?php
namespace App\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonCircularSerializer
{
    /**
     * @var serializer
     */
    private $serializer;

    /**
     * EcoleController constructor.
     */
    public function __construct()
    {
        //Gestion des circulations
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getNom();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $this->serializer = new Serializer([$normalizer], [new JsonEncoder()]);


    }

    public function serialize($object):string{
        return $this->serializer->serialize($object, 'json');
    }

}