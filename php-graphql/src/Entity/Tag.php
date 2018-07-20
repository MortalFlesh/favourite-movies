<?php declare(strict_types=1);

namespace MF\FavoriteMovies\GraphQL\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use MF\Collection\Immutable\ITuple;
use MF\Collection\Immutable\Tuple;

/**
 * @ORM\Entity(repositoryClass="MF\FavoriteMovies\GraphQL\Repository\TagRepository")
 */
class Tag implements MoviePartInterface, UniquePartInterface
{
    use ManyToManyMoviePartTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var int|null
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $title;
    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    private $link;
    /**
     * @ORM\ManyToMany(targetEntity="MF\FavoriteMovies\GraphQL\Entity\Movie", inversedBy="tags")
     * @var Movie[]|Collection
     */
    private $movies;

    public function __construct(string $title, string $link)
    {
        $this->title = $title;
        $this->link = $link;
        $this->movies = new ArrayCollection();
    }

    public function getCollection(Movie $movie): Collection
    {
        return $movie->getTags();
    }

    public function getKey(): ITuple
    {
        return Tuple::of('link', $this->link);
    }
}
