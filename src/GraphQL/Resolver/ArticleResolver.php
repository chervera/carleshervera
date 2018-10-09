<?php
namespace App\GraphQL\Resolver;

use Doctrine\ORM\EntityManager;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class ArticleResolver implements ResolverInterface, AliasedInterface {

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function resolve(Argument $args)
    {
        $article = $this->em->getRepository('App:Article')->find($args['id']);
        return $article;
    }

    public static function getAliases()
    {
        return [
            'resolve' => 'Article'
        ];
    }
}