<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Tweet;
use AppBundle\Entity\TweetRepository;
use AppBundle\Entity\Author;
use AppBundle\Entity\AuthorRepository;
use AppBundle\Utils\TwitterAPIExchange;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

     /**
     * Lists all tweets.
     *
     * @Route("/api", name="api_main")
     * @Method("GET")
     */
    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $tweets= $em->getRepository('AppBundle:Tweet')->findBy(
            array(),
            array('creationDate'=>'DESC'),
            10,
            0
            );
        
        $response = new Response(json_encode($tweets));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Lists all tweets.
     *
     * @Route("/index", name="index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $tweets= $em->getRepository('AppBundle:Tweet')->findBy(
            array(),
            array('creationDate'=>'DESC'),
            10,
            0
            );
        
        return array('tweets'=>$tweets);
    }

}
