<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Tweet;

/**
 * Tweet controller.
 *
 * @Route("/tweet")
 */
class TweetController extends Controller
{

    /**
     * Lists all Tweet entities.
     *
     * @Route("/", name="tweet")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Tweet')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Tweet entity.
     *
     * @Route("/{id}", name="tweet_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Tweet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tweet entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
