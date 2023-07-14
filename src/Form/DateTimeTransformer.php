<?php

namespace App\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateTimeTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        // transforme l'objet DateTime en string (format attendu par le champ de formulaire)
        return $value->format('Y-m-d');
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return null;
        }

        // transforme la valeur string en objet DateTime
        $dateTime = \DateTime::createFromFormat('Y-m-d', $value);

        if (false === $dateTime) {
            // throw exception en cas d'échec de transformation
            throw new TransformationFailedException('Format de date invalide');
        }

        return $dateTime;
    }
}
