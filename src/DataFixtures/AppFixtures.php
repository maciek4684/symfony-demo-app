<?php

namespace App\DataFixtures;

use App\Entity\ApiToken;
use App\Entity\AppUser;
use App\Entity\CodeLanguage;
use App\Entity\SubmitType;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $hasher;

    public function __construct(
        UserPasswordHasherInterface $hasher
    )
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        $user = new AppUser();
        $password = $this->hasher->hashPassword($user, 'P@ssw0rd');
            $user->setEmail('admin@example.com')
            ->setPassword($password)
            ->setSlug("admin")
            ->setRoles(["ROLE_ADMIN"]);

        $token = new ApiToken($user);
        $token->setToken('admintoken');

        $manager->persist($user);
        $manager->persist($token);
        $manager->flush();

        $user = new AppUser();
        $password = $this->hasher->hashPassword($user, 'pass1');
        $user->setEmail('user1@example.com')
            ->setPassword($password)
            ->setSlug("user1")
            ->setRoles(["ROLE_USER"]);

        $token = new ApiToken($user);
        $token->setToken('user1token');

        $manager->persist($user);
        $manager->persist($token);
        $manager->flush();

        $user = new AppUser();
        $password = $this->hasher->hashPassword($user, 'pass2');

        $user->setEmail('user2@example.com')
            ->setPassword($password)
            ->setSlug("user2")
            ->setRoles(["ROLE_USER"]);

        $token = new ApiToken($user);
        $token->setToken('user2token');

        $manager->persist($user);
        $manager->persist($token);
        $manager->flush();

        $codeLanguage = new CodeLanguage();

        $codeLanguage->setShortName("cs")
            ->setFullName("C#");

        $manager->persist($codeLanguage);
        $manager->flush();

        $submitType = new SubmitType();
        $submitType->setName("code");

        $manager->persist($submitType);
        $manager->flush();

        $task = new Task();
        $task->setSlug("maximum");
        $task->setTitle("Find a maximum element");
        $task->setDescription("<p>Create a function <code>int? ReturnMax(int[] arr)</code> that finds and returns the maximum element in an input array.</p>
            <br><br><i>Note: this app is for demonstration purposes only. It is not sending the code to the real code testing API. It is sending the data to the API endpoint
            that always returns the same data structure, containing fake: <ul><li>5 unit tests executed on the code</li><li>1 compiler error</li><li>1 compiler warning</li></ul>
             <p>It also puts red markers in the editor on lines where compiler errors and warnings have been identified.</p></i>");
        $task->addCodeLanguage($codeLanguage);
        $task->addSubmitType($submitType);

        $manager->persist($task);
        $manager->flush();

        $task = new Task();
        $task->setSlug("minimum");
        $task->setTitle("Find a minimum element");
        $task->setDescription("<p>Create a function <code>int? ReturnMin(int[] arr)</code> that finds and returns the minimum element in an input array.</p>
            <br><br><i>Note: this app is for demonstration purposes only. It is not sending the code to the real code testing API. It is sending the data to the API endpoint
            that always returns the same data structure, containing fake: <ul><li>5 unit tests executed on the code</li><li>1 compiler error</li><li>1 compiler warning</li></ul>
             <p>It also puts red markers in the editor on lines where compiler errors and warnings have been identified.</p></i>");
        $task->addCodeLanguage($codeLanguage);
        $task->addSubmitType($submitType);

        $manager->persist($task);
        $manager->flush();


        $task = new Task();
        $task->setSlug("optimum");
        $task->setTitle("Identify optimal solution");
        $task->setDescription("<p>Create a function <code>int? ReturnMin(int[] arr)</code> that finds and returns the minimum element in an input array.</p>
            <br><br><i>Note: this app is for demonstration purposes only. It is not sending the code to the real code testing API. It is sending the data to the API endpoint
            that always returns the same data structure, containing fake: <ul><li>5 unit tests executed on the code</li><li>1 compiler error</li><li>1 compiler warning</li></ul>
             <p>It also puts red markers in the editor on lines where compiler errors and warnings have been identified.</p></i>");
        $task->addCodeLanguage($codeLanguage);
        $task->addSubmitType($submitType);

        $manager->persist($task);
        $manager->flush();


        $task = new Task();
        $task->setSlug("sort-1");
        $task->setTitle("Sort elements ascending");
        $task->setDescription("<p>Create a function <code>int? ReturnMin(int[] arr)</code> that finds and returns the minimum element in an input array.</p>
            <br><br><i>Note: this app is for demonstration purposes only. It is not sending the code to the real code testing API. It is sending the data to the API endpoint
            that always returns the same data structure, containing fake: <ul><li>5 unit tests executed on the code</li><li>1 compiler error</li><li>1 compiler warning</li></ul>
             <p>It also puts red markers in the editor on lines where compiler errors and warnings have been identified.</p></i>");
        $task->addCodeLanguage($codeLanguage);
        $task->addSubmitType($submitType);

        $manager->persist($task);
        $manager->flush();


        $task = new Task();
        $task->setSlug("sort-2");
        $task->setTitle("Sort elements descending");
        $task->setDescription("<p>Create a function <code>int? ReturnMin(int[] arr)</code> that finds and returns the minimum element in an input array.</p>
            <br><br><i>Note: this app is for demonstration purposes only. It is not sending the code to the real code testing API. It is sending the data to the API endpoint
            that always returns the same data structure, containing fake: <ul><li>5 unit tests executed on the code</li><li>1 compiler error</li><li>1 compiler warning</li></ul>
             <p>It also puts red markers in the editor on lines where compiler errors and warnings have been identified.</p></i>");
        $task->addCodeLanguage($codeLanguage);
        $task->addSubmitType($submitType);

        $manager->persist($task);
        $manager->flush();


        $task = new Task();
        $task->setSlug("order-1");
        $task->setTitle("Order elements in a defined way");
        $task->setDescription("<p>Create a function <code>int? ReturnMin(int[] arr)</code> that finds and returns the minimum element in an input array.</p>
            <br><br><i>Note: this app is for demonstration purposes only. It is not sending the code to the real code testing API. It is sending the data to the API endpoint
            that always returns the same data structure, containing fake: <ul><li>5 unit tests executed on the code</li><li>1 compiler error</li><li>1 compiler warning</li></ul>
             <p>It also puts red markers in the editor on lines where compiler errors and warnings have been identified.</p></i>");
        $task->addCodeLanguage($codeLanguage);
        $task->addSubmitType($submitType);

        $manager->persist($task);
        $manager->flush();

        $task = new Task();
        $task->setSlug("order-2");
        $task->setTitle("Order elements according to a given rule set");
        $task->setDescription("<p>Create a function <code>int? ReturnMin(int[] arr)</code> that finds and returns the minimum element in an input array.</p>
            <br><br><i>Note: this app is for demonstration purposes only. It is not sending the code to the real code testing API. It is sending the data to the API endpoint
            that always returns the same data structure, containing fake: <ul><li>5 unit tests executed on the code</li><li>1 compiler error</li><li>1 compiler warning</li></ul>
             <p>It also puts red markers in the editor on lines where compiler errors and warnings have been identified.</p></i>");
        $task->addCodeLanguage($codeLanguage);
        $task->addSubmitType($submitType);

        $manager->persist($task);
        $manager->flush();
    }
}
