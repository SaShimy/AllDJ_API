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
use AppBundle\Entity\Room;
use AppBundle\Entity\Room_music_type;
use AppBundle\Entity\UserRoomFollow;
use AppBundle\Entity\Room_waiting_list;
use AppBundle\Entity\Room_actual_music;


/**
* @Route("/room")
*/
class RoomController extends FOSRestController
{
  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Get all rooms",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  }
  * )
  * @Rest\Get("/all")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getAllRoomsAction(Request $request)
  {
    $result = $this->getDoctrine()->getManager()->createQueryBuilder();
    $rooms = $result->select('r.id', 'r.name', 'r.nbFollowers', 'ram.musicYtId', 'mt.name as type')
      ->from('AppBundle:Room', 'r')
      ->leftJoin('r.actual_music', 'ram')
      ->leftJoin('r.music_types', 'rmt')
      ->leftJoin('rmt.music_type', 'mt')
      ->orderBy('r.nbFollowers', 'DESC')
      ->getQuery()
      ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

    return new Response (json_encode($rooms));
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Get room",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  }
  * )
  *   parameters= {
  *      {"name"="id", "dataType"="integer", "required"=true, "description"="Room id"},
  *  }
  * @Rest\Get("/details/{id}")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getRoomAction(Request $request, $id)
  {
    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Room');
    $room = $repository->find($id);

    $serializer = $this->container->get('jms_serializer');
    $reports = $serializer->serialize($room, 'json');

    return new Response($reports);
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Add a new room",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *   parameters= {
  *      {"name"="name", "dataType"="string", "required"=true, "description"="Room name"},
  *      {"name"="types", "dataType"="string", "required"=true, "description"="List of music type id, with ';' as delimiter"},
  *   }
  * )
  * @Rest\Post("/api/new")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function newRoomAction(Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $data = $request->request->all();
    $em = $this->getDoctrine()->getManager();

    $room = new Room();
    $room->setUserId($user->getId());
    $room->setName($data["name"]);
    $room->setNbFollowers(1);
    $room->setCreatedAt(new \DateTime());
    $room->setUpdatedAt(new \DateTime());
    $em->persist($room);
    $em->flush();

    $array_type = explode(';', $data["types"]);

    foreach ($array_type as $type_id) {
      $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:music_type');
      $music_type = $repository->find($type_id);

      $room_music_type = new Room_music_type();
      $room_music_type->setRoom($room);
      $room_music_type->setMusicType($music_type);
      $em->persist($room_music_type);
    }

    $em->flush();
    return new Response (json_encode(array('message' => 'Room "' . $data["name"] . '" has been created successfully')));
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Follow a room",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Post("/api/{id}/follow")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function followRoomAction(Request $request, Room $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();

    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:UserRoomFollow');
    if (!empty($repository->findOneByUserAndRoom($user, $id)))
      return new Response (json_encode(array('message' => 'Vous suivez déjà la room ' . $id->getName())));

    $em = $this->getDoctrine()->getManager();
    $userRoomFollow = new UserRoomFollow();
    $userRoomFollow->setUser($user);
    $userRoomFollow->setRoom($id);
    $id->setNbFollowers($id->getNbFollowers()+1);
    $em->persist($userRoomFollow);
    $em->flush();

    return new Response (json_encode(array('message' => 'Vous suivez désormais la room ' . $id->getName())));
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Get room's waiting list",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Get("/api/{id}/waiting_list")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getRoomWaitingListAction(Request $request, Room $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();

    $waiting_list = $id->getWaitingList();
    $i = 0;
    foreach ($waiting_list as $user)
    {
      $waiting_list_user[$i]["username"] = $user->getUser()->getUsername();
      $waiting_list_user[$i]["music"] = $user->getMusicYtId();
      $i++;
    }
    $serializer = $this->container->get('jms_serializer');
    $reports = $serializer->serialize($waiting_list_user, 'json');

    return new Response($reports);
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Join the room's waiting list",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *     parameters= {
  *      {"name"="musicId", "dataType"="string", "required"=true, "description"="Youtube music id"},
  *      {"name"="duration", "dataType"="string", "required"=true, "description"="Youtube music duration"},
  *      {"name"="musicName", "dataType"="string", "required"=true, "description"="Youtube music name"},
  *   }
  * )
  * @Rest\Post("/api/{id}/waiting_list/join")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function newRoomWaitingListAction(Request $request, Room $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $data = $request->request->all();
    $em = $this->getDoctrine()->getManager();

    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Room_waiting_list');
    if (!empty($repository->findOneByUserAndRoom($user, $id)))
      return new Response (json_encode(array('message' => 'Vous êtes déjà dans la file d\'attente')), 200);
    if ($id->getActualMusic() && $id->getActualMusic()->getUser()->getId() == $user->getId())
      return new Response (json_encode(array('message' => 'Vous êtes déjà le DJ')), 200);

    $duration = $this->get('app.tools')->changeFormatMusicDuration($data["duration"]);

    if ($this->getDoctrine()->getManager()->getRepository('AppBundle:Room_waiting_list')->getNbDJ($id) > 0 || $id->getActualMusic())
    {
      $room_waiting_list = new Room_waiting_list();
      $room_waiting_list->setUser($user);
      $room_waiting_list->setRoom($id);
      $room_waiting_list->setMusicYtId($data["musicId"]);
      $room_waiting_list->setMusicDuration($duration);
      $room_waiting_list->setMusicName($data["musicName"]);
      $em->persist($room_waiting_list);
      $em->flush();
    }
    else

    {
      $new_music = new Room_actual_music();
      $new_music->setUser($user);
      $new_music->setRoom($id);
      $new_music->setStart(time());
      $new_music->setMusicYtId($data["musicId"]);
      $new_music->setMusicDuration($duration);
      $new_music->setMusicName($data["musicName"]);
      $em->persist($new_music);
      $em->flush();
    }

    return new Response (json_encode(array('message' => 'Vous êtes désormais dans la file d\'attente !')), 200);
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Change music",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *     parameters= {
  *      {"name"="musicId", "dataType"="string", "required"=true, "description"="Youtube music id"},
  *      {"name"="duration", "dataType"="string", "required"=true, "description"="Youtube music duration"},
  *      {"name"="musicName", "dataType"="string", "required"=true, "description"="Youtube music name"},
  *   }
  * )
  * @Rest\Post("/api/{id}/waiting_list/music/update")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function updateRoomWaitingListMusicAction(Request $request, Room $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $data = $request->request->all();
    $em = $this->getDoctrine()->getManager();

    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Room_waiting_list');
    $room_waiting_list = $repository->findOneByUserAndRoom($user, $id);

    $room_waiting_list->setMusicYtId($data["musicId"]);
    $room_waiting_list->setMusicName($data["musicName"]);
    $room_waiting_list->setMusicDuration($data["duration"]);

    $em->persist($room_waiting_list);
    $em->flush();

    return new Response (json_encode(array('message' => 'Musique modifiée')), 200);
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Get room actual playlist",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Get("/api/{id}/music")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getRoomActualMusic(Request $request, Room $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Room_actual_music');
    $em = $this->getDoctrine()->getManager();
    $actual_music = $repository->findOneByRoom($id);
    if (!$actual_music)
      return new Response(json_encode(array("message" => "Aucune musique pour le moment")), 200);

    $start = $actual_music->getStart();
    $time = time() - $start;
    if ($time >= $actual_music->getMusicDuration())
    {
      $next_dj = $this->getDoctrine()->getManager()->getRepository('AppBundle:Room_waiting_list')->getFirstDj($id);

      if ($this->getDoctrine()->getManager()->getRepository('AppBundle:Room_waiting_list')->getNbDJ($id) > 0)
      {
        $actual_music->setUser($next_dj->getUser());
        $actual_music->setRoom($next_dj->getRoom());
        $actual_music->setStart(time());
        $actual_music->setMusicYtId($next_dj->getMusicYtId());
        $actual_music->setMusicDuration($next_dj->getMusicDuration());
        $em->persist($actual_music);
        $em->remove($next_dj);
        $em->flush();
        $time = 0;
      }
      else
      {
        $em->remove($actual_music);
        $em->flush();
        return new Response(json_encode(array("message" => "Aucune musique pour le moment")), 200);
      }
    }
    $array = array();
    $array["music_id"] = $actual_music->getMusicYtId();
    if ($user->getId() == $actual_music->getUser()->getId())
      $array["is_master"] = true;
    else
      $array["is_master"] = false;
    $array["time"] = $time;
    $array["name"] = $actual_music->getMusicName();

    $serializer = $this->container->get('jms_serializer');
    $reports = $serializer->serialize($array, 'json');

    return new Response($reports);
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Update room waiting list",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  }
  * )
  * @Rest\Post("/api/{id}/music/update")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function updateRoomWaitingListAction(Request $request, Room $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $data = $request->request->all();
    $em = $this->getDoctrine()->getManager();

    $next_dj = $this->getDoctrine()->getManager()->getRepository('AppBundle:Room_waiting_list')->getFirstDj($id);

    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Room_actual_music');
    $actual_music = $repository->findOneByRoom($id);

    if ($this->getDoctrine()->getManager()->getRepository('AppBundle:Room_waiting_list')->getNbDJ($id) > 0)
    {
      $actual_music->setUser($next_dj->getUser());
      $actual_music->setRoom($next_dj->getRoom());
      $actual_music->setStart(time());
      $actual_music->setMusicYtId($next_dj->getMusicYtId());
      $actual_music->setMusicDuration($next_dj->getMusicDuration());
      $em->persist($actual_music);
      $em->remove($next_dj);
      $em->flush();
    }
    else
    {
      $em->remove($actual_music);
      $em->flush();
    }

    return new Response(json_encode(array("message" => "OK")));
  }

  /**
  * @ApiDoc(
  *  section="Room",
  *  resource=false,
  *  description="Leave the room's waiting list",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Post("/api/{id}/waiting_list/leave")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function leaveRoomWaitingListAction(Request $request, Room $id)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();

    $em = $this->getDoctrine()->getManager();

    $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Room_waiting_list');
    $waiting_list_user = $repository->findOneByUser($user);

    $em->remove($waiting_list_user);
    $em->flush();

    return new Response (json_encode(array('message' => 'Vous avez quitté la file d\'attente !')), 200);
  }
}
