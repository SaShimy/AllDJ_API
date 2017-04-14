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
use AppBundle\Entity\Playlist;
use AppBundle\Entity\Playlist_music;



/**
* @Route("/playlist")
*/
class PlaylistController extends FOSRestController
{
  /**
  * @ApiDoc(
  *  section="Playlist",
  *  resource=false,
  *  description="Get user playlists",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Get("/api/me")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */

  public function getUserPlaylistsAction(Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $result = $this->getDoctrine()->getManager()->createQueryBuilder();
    $playlists = $result->select('p')
      ->from('AppBundle:Playlist', 'p')
      ->where('p.userId= :userId ')
      ->setParameters(array('userId' => $user->getId()))
      ->orderBy('p.createdAt', 'DESC')
      ->getQuery()
      ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    return new Response (json_encode($playlists));
  }

  /**
  * @ApiDoc(
  *  section="Playlist",
  *  resource=false,
  *  description="Create a new playlist",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *   parameters= {
  *      {"name"="name", "dataType"="string", "required"=true, "description"="Playlist name"},
  *      {"name"="isPublic", "dataType"="string", "required"=true, "description"="'true' = public playlist, 'false' = private playlist"},
  *   }
  * )
  * @Rest\Post("/api/new")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function newPlaylistAction(Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $data = $request->request->all();
    $em = $this->getDoctrine()->getManager();

    $playlist = new Playlist();
    $playlist->setUserId($user->getId());
    $playlist->setName($data["name"]);
    if ($data["isPublic"] == "true")
      $playlist->setIsPublic(true);
    else
      $playlist->setIsPublic(false);
    $playlist->setCreatedAt(new \DateTime());
    $playlist->setUpdatedAt(new \DateTime());
    $em->persist($playlist);
    $em->flush();

    return new Response (json_encode(array('message' => 'Playlist "' . $data["name"] . '" has been created successfully')));
  }

  /**
  * @ApiDoc(
  *  section="Playlist",
  *  resource=false,
  *  description="add music to playlist",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *   parameters= {
  *      {"name"="name", "dataType"="string", "required"=true, "description"="Music name"},
  *      {"name"="musicId", "dataType"="string", "required"=true, "description"="Youtube music id"},
  *      {"name"="imgUrl", "dataType"="string", "required"=true, "description"="Image url"},
  *   }
  * )
  * @Rest\Post("/api/{id}/music/add")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function addMusicToPlaylistAction(Request $request, Playlist $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $data = $request->request->all();
    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Playlist');

    if ($user->getId() != $id->getUserId())
        return new Response (json_encode(array('message' => 'Unauthorized')));

    $em = $this->getDoctrine()->getManager();

    $playlist_music = new Playlist_music();
    $playlist_music->setPlaylist($id);
    $playlist_music->setName($data["name"]);
    $playlist_music->setMusicYtId($data["musicId"]);
    $playlist_music->setImgUrl($data["imgUrl"]);
    $em->persist($playlist_music);
    $em->flush();

    return new Response (json_encode(array('message' => $data["name"] . ' has been added to the playlist')));
  }

  /**
  * @ApiDoc(
  *  section="Playlist",
  *  resource=false,
  *  description="Get playlist",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  }
  * )
  *   parameters= {
  *      {"name"="id", "dataType"="integer", "required"=true, "description"="Playlist id"},
  *  }
  * @Rest\Get("/api/{id}/details")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getPlaylistAction(Request $request, Playlist $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Playlist');

    if (!$id->getIsPublic() && $user->getId() != $id->getUserId())
      return new Response (json_encode(array('message' => 'Playlist privée')), 400);

    $serializer = $this->container->get('jms_serializer');
    $reports = $serializer->serialize($id, 'json');

    return new Response($reports);
  }

  /**
  * @ApiDoc(
  *  section="Playlist",
  *  resource=false,
  *  description="Remove playlist",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  }
  * )
  *
  * @Rest\Post("/api/{id}/remove")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function removePlaylistAction(Request $request, Playlist $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();

    if ($id->getUserId() != $user->getId())
      return new Response (json_encode(array('message' => 'Unauthorized')), 400);

    $em = $this->getDoctrine()->getEntityManager();


    foreach ($id->getMusics() as $music_playlist)
      $em->remove($music_playlist);
    $em->flush();

    $em->remove($id);
    $em->flush();

    return new Response(json_encode(array('message' => 'La playlist a été supprimée')), 200);
  }

  /**
  * @ApiDoc(
  *  section="Playlist",
  *  resource=false,
  *  description="Remove music from playlist",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  }
  * )
  *
  * @Rest\Post("/api/{id}/music/{id_music}/remove")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function removePlaylistMusicAction(Request $request, Playlist $id, Playlist_music $id_music)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();

    if ($id->getUserId() != $user->getId())
      return new Response (json_encode(array('message' => 'Unauthorized')), 400);

    $em = $this->getDoctrine()->getEntityManager();
    $em->remove($id_music);
    $em->flush();

    return new Response(json_encode(array('message' => 'La musique a été supprimée')), 200);
  }
}
