<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('tweet:update')
            ->setDescription('Update tweet');
    }

    protected function updateItems($em, $ar, $settings, $limit, $output){
        $authors= $ar->findBy(
            array(),
            array('updateDate'=>'ASC'),
            $limit,
            0
            );
        $now = new \DateTime();
        foreach ($authors as $author) {
            $lastUp = $now->getTimestamp()-$author->getUpdateDate()->getTimestamp();
            if($lastUp>120){
                $output->writeln(memory_get_usage()."Updating : ".$author->getTwitterId());
                try{
                    $ar->update($author->getTwitterId(), $em, $settings);
                }
                catch(\Exception $e){
                    $output->writeln('Exception ==> '.$e->getMessage());
                }
            }
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $ar = $em->getRepository('AppBundle:Author');
        $output->writeln("Starting update...");
        $params=['oauth_access_token','oauth_access_token_secret','consumer_key','consumer_secret'];
        $settings = array();
        foreach ($params as $p) {
           $settings[$p]=$this->getContainer()->getParameter($p);
        }
        $twitterRequests = 0;
        while(1){
            $before = new \DateTime();
            $this->updateItems($em, $ar, $settings, 10, $output);
            $after = new \DateTime();
            $delta = $after->getTimestamp()-$before->getTimestamp();
            if($delta <25){
                $output->writeln( memory_get_usage()."Sleeping ".(25-$delta)."s...");
                sleep(25-$delta);
            }
            gc_collect_cycles();
        }
    }
}