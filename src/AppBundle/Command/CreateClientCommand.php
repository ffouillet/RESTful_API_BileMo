<?php
namespace AppBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('createClient')
            ->setDescription('Create a client for BileMo API')
            ->addOption('redirect_url', null, InputOption::VALUE_REQUIRED, 'Url redirection after authorization')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getOption('redirect_url');

        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array($url));
        $client->setAllowedGrantTypes(array('password', 'refresh_token'));
        $clientManager->updateClient($client);
        $output->writeln("Added a new client with client_id : <info>".$client->getPublicId()."</info> and client_secret : <info>".$client->getSecret()."</info>");
    }
}