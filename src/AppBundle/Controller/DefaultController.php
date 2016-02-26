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
     * @Route("/api/{typeId}", name="api_main")
     * @Method("GET")
     */
    public function getAction($typeId)
    {
        $em = $this->getDoctrine()->getManager();
        
        $tweets= $em->getRepository('AppBundle:Tweet')->findByAuthorType($typeId);
        $response = new Response(json_encode($tweets));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
    * Lists all tweets after or before some point
    *
    * @Route("/api/{typeId}/{id}/{border}", name="api_last")
    * @Method("GET")
    */
    public function getLastAction($id, $border, $typeId)
    {
        $em = $this->getDoctrine()->getManager();
        if($border==='asc')
            $border = '>';
        elseif ($border==='desc') {
            $border = '<';
        } else {
            $response = new Response('[]');
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        $tweets= $em->getRepository('AppBundle:Tweet')->findLastTweets($id, $border, $typeId);
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
        
        $tweets= [];/*$em->getRepository('AppBundle:Tweet')->findBy(
            array(),
            array('creationDate'=>'DESC'),
            10,
            0
            );*/
        
        return array('tweets'=>$tweets);
    }

}
