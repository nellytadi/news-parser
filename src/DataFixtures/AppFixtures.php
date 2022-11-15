<?php

namespace App\DataFixtures;

use App\Entity\News;
use App\Entity\Source;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void {
        $this->seedUsers($manager);
        $this->seedNewsAndSource($manager);
    }

    private function seedUsers(ObjectManager $manager): void {
        $usersData = array(
            ['username' =>'moderator', 'email'=> 'moderator@example.com', 'password'=>'123456', 'roles' => ['ROLE_MODERATOR']],
            ['username' =>'admin', 'email'=> 'admin@example.com', 'password'=>'123456', 'roles' => ['ROLE_ADMIN']],
        );
        foreach ($usersData as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);

            $manager->persist($user);
            $this->addReference($userData['username'], $user);
        }

        $manager->flush();
    }



    private function seedNewsAndSource(ObjectManager $manager): void {
        $source = new Source();
        $source->setUrl('https://highload.today/category/novosti/');
        $source->setCreatedAt(new \DateTimeImmutable());
        $source->setTitle('Highload.today');
        $manager->persist($source);


        for ($i = 1; $i <= 11; $i++) {
            $news = new News();
            $news->setTitle('News Article '. $i);
            $news->setDescription('News Article Description '. $i);
            $news->setImage('https://cdn.searchenginejournal.com/wp-content/uploads/2020/08/7-ways-a-blog-can-help-your-business-right-now-5f3c06b9eb24e-1280x720.png');
            $news->setUpdatedAt(new \DateTimeImmutable());
            $news->setCreatedAt(new \DateTimeImmutable());
            $news->setSource($source);
            $manager->persist($news);

            $manager->flush();
        }
    }
}
