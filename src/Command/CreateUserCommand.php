<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create:user';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * CreateUserCommand constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $manager
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->passwordEncoder = $passwordEncoder;
        $this->manager = $manager;
    }

    protected function configure() {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new user.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a user...')
            // configure arguments
            ->addArgument('email', InputArgument::REQUIRED, 'The username of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password')
            ->addArgument('role', InputArgument::REQUIRED, 'The role')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputs = $input->getArguments();

        $user = new User();

        $user->setEmail($inputs['email']);
        $user->setRoles([$inputs['role']]);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $inputs['password']
        ));

        $this->manager->persist($user);

        $this->manager->flush();

        $output->writeln([
            'Created user '.$user->getEmail(),
            'with roles: '.implode(',', $user->getRoles()),
        ]);

        return 0;
    }
}