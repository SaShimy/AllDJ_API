<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

use AppBundle\Entity\User;
use AppBundle\Entity\music_type;



/**
* @Route("/music_type")
*/
class MusicTypeController extends FOSRestController
{
  /**
  * @ApiDoc(
  *  section="Music type",
  *  resource=false,
  *  description="Get types",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Get("/types")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getMusicTypes(Request $request)
  {
    $result = $this->getDoctrine()->getManager()->createQueryBuilder();
    $sessions = $result->select('mt')
      ->from('AppBundle:music_type', 'mt')
      ->getQuery()
      ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    return new Response (json_encode($sessions));
  }

  /**
  * @ApiDoc(
  *  section="Music type",
  *  resource=false,
  *  description="ADD new music type",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *  parameters= {
  *      {"name"="name", "dataType"="string", "required"=true, "description"="Music type name"},
  *      {"name"="description", "dataType"="string", "required"=true, "description"="Music type description"},
  *      {"name"="file", "dataType"="file", "required"=false, "descirption"="Music type file"}
  *   }
  * )
  * @Rest\Post("/add")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function addMusicType(Request $request)
  {
    $result = $this->getDoctrine()->getManager()->createQueryBuilder();
    $data = $request->request->all();
    $em = $this->getDoctrine()->getManager();
    $music_type = new music_type();
    if (isset($data["file"]))
    {
      $file = $request->files->get('file');

      $filename = "musictype_image_".$data["name"];
      $path = $this->get('app.file_uploader')->upload($file, $filename, "music_type");

      $file = new File();
      $file->setPath($path);

      $em->persist($file);
      $em->flush();
      $music_type->setFile($file);
    }
    $music_type->setName($data["name"]);
    $music_type->setDescription($data["description"]);

    $em->persist($music_type);
    $em->flush();
    return new Response (json_encode(array("message" => $data["name"]." ajouté aux styles de musiques")));
  }

  /**
  * @ApiDoc(
  *  section="Music type",
  *  resource=false,
  *  description="Get Music type details with rooms",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  }
  * )
  * @Rest\Get("/details/{id}")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getMusicType(Request $request, music_type $id)
  {
    $serializer = $this->container->get('jms_serializer');
    $reports = $serializer->serialize($id, 'json');

    return new Response ($reports);
  }
}
