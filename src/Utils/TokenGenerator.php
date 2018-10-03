<?php

namespace App\Utils;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;
use RandomLib\Factory;

class TokenGenerator extends AbstractIdGenerator
{
    const LENGTH = 16;
    const VOCAB = 'ABCDEFGHIJKLMNOPQRSTUVXYZ0123456789';
    const MAX_ATTEMPTS = 10000;

    public function generate(EntityManager $em, $entity) {
        $entity_name = $em->getClassMetadata(get_class($entity))->getName();
        $attempt = 0;
        while (true) {
            $token = self::generateToken(6, self::VOCAB);
            $item = $em->find($entity_name, $token);

            if (!$item) {
                return $token;
            }

            $attempt++;
            if ($attempt > self::MAX_ATTEMPTS) {
                throw new \Exception('TokenGenerator tried hardly 10000 times, but failed to generate a new unique token.');
            }
        }
    }

    public static function generateToken(int $length = self::LENGTH, string $vocab = self::VOCAB): string {
        $generator = (new Factory())->getMediumStrengthGenerator();
        return $generator->generateString($length, $vocab);
    }
}