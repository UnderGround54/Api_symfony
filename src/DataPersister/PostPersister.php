<?php 

namespace App\DataPersister;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class PostPersister implements DataPersisterInterface
{
    protected $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function supports($data): bool
    {
        return $data instanceof Post;
    }

    public function persist($data)
    {
        $data->setCreatedAt(New \DateTime());
        $this->manager->persist($data);
        $this->manager->flush();

    }

    public function remove($data)
    {
        $this->manager->remove($data);
        $this->manager->flush();

    }
}