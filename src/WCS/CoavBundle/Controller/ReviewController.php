<?php
/**
 * Created by PhpStorm.
 * User: mar
 * Date: 31/10/17
 * Time: 08:41
 */

namespace WCS\CoavBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WCS\CoavBundle\Entity\Review;

class ReviewController extends Controller
{
    /**
     * Lists all review entities.
     *
     * @Route("/review", name="review_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reviews = $em->getRepository('WCSCoavBundle:Review')->findAll();

        return $this->render(':review:index.html.twig', array(
            'reviews' => $reviews,
        ));
    }

    /**
     * Creates a new review entity.
     *
     * @Route("/review/new", name="review_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $review = new Review();
        $form = $this->createForm('WCS\CoavBundle\Form\ReviewType', $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('review_index', array('id' => $review->getId()));
        }

        return $this->render('review/index.html.twig', array(
            'review' => $review,
            'form' => $form->createView(),
        ));
    }

}