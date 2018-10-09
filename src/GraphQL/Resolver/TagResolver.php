<?php
namespace App\GraphQL\Resolver;

use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class TagResolver implements ResolverInterface, AliasedInterface {

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function resolve(Argument $args)
    {
        $tag = $this->em->getRepository('App:Tag')->find($args['id']);
        return $tag;
    }

    public static function getAliases()
    {
        return [
            'resolve' => 'Tag'
        ];
    }
}