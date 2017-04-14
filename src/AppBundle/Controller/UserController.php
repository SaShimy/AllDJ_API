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
use AppBundle\Entity\File;




/**
* @Route("/user")
*/
class UserController extends FOSRestController
{
  /**
  * @ApiDoc(
  *  section="Utilisateurs",
  *  resource=false,
  *  description="Inscription",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *   parameters= {
  *      {"name"="login", "dataType"="string", "required"=true, "description"="Login user"},
  *      {"name"="mail", "dataType"="string", "required"=true, "description"="Mail user"},
  *      {"name"="password", "dataType"="string", "required"=true, "description"="Password"},
  *   }
  * )
  * @Rest\Post("/signup")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function createUserAction(Request $request)
  {
    $data = $request->request->all();
    if (!filter_var($data["mail"], FILTER_VALIDATE_EMAIL))
      return new Response (json_encode(array('message' => 'Email invalide.')), 400);
    $username = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->findOneByUsername($data["login"]);
    if ($username)
      return new Response (json_encode(array('message' => 'Nom d\'utilisateur déjà utilisée.')), 400);
    $mail = $this->getDoctrine()
        ->getRepository('AppBundle:User')
        ->findOneByEmail($data["mail"]);
    if ($mail)
      return new Response (json_encode(array('message' => 'Email déjà utilisée.')), 400);
    $user = new User();
    $user->setUsername($data["login"]);
    //$user->setFirstname($data["firstname"]);
    //$user->setLastname($data["lastname"]);
    $user->setEmail($data["mail"]);
    $user->setPlainPassword($data["password"]);
    $user->setEnabled((Boolean) true);
    /* $birthday = date_create_from_format('d/m/Y', $data["birthday"]);
    $birthDate = explode("/", $data["birthday"]);
    $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")
          ? ((date("Y") - $birthDate[2]) - 1)
          : (date("Y") - $birthDate[2]));
    $user->setBirthday($birthday);
    $user->setAge($age);
    $user->setGender($data["gender"]); */
    $em = $this->getDoctrine()->getManager();
    $em->persist($user);
    $em->flush();
    return new Response (json_encode(array('message' => 'Utilisateur créé', 'login' => $data["login"])));
  }

  /**
  * @ApiDoc(
  *  section="Utilisateurs",
  *  resource=false,
  *  description="Get actual user profile",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Get("/api/profile")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getMyUserAction(Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $serializer = $this->container->get('jms_serializer');
    $reports = $serializer->serialize($user, 'json');

    return new Response($reports);
  }

  /**
  * @ApiDoc(
  *  section="Utilisateurs",
  *  resource=false,
  *  description="Get USER by ID",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Get("/api/profile/{id}")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getUserAction(Request $request, User $id)
  {
    $serializer = $this->container->get('jms_serializer');
    $reports = $serializer->serialize($id, 'json');

    return new Response($reports);
  }

  /**
  * @ApiDoc(
  *  section="Utilisateurs",
  *  resource=false,
  *  description="UPDATE User",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *   parameters= {
  *      {"name"="firstname", "dataType"="string", "required"=false, "description"="Firstname User"},
  *      {"name"="mail", "dataType"="string", "required"=false, "description"="Mail utilisateur"},
  *      {"name"="lastname", "dataType"="string", "required"=false, "description"="Lastname User"},
  *      {"name"="birthday", "dataType"="string", "required"=false, "description"="Birthday User, format dd/mm/yyyy"},
  *      {"name"="gender", "dataType"="string", "required"=false, "description"="Gender User, 'female' or 'male'"}
  *   }
  * )
  * @Rest\Post("/api/update")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function updateUserAction(Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $data = $request->request->all();
    if (isset($data["mail"]))
    {
      if (!filter_var($data["mail"], FILTER_VALIDATE_EMAIL))
        return new Response (json_encode(array('message' => 'Email invalide.')), 400);
      if ($user->getEmail() != $data["mail"])
      {
        $exist = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findOneByEmail($data["mail"]);
        if ($exist)
          return new Response (json_encode(array('message' => 'Email déjà utilisée.')), 400);
      }
      $user->setEmail($data["mail"]);
    }
    if (isset($data["birthday"]))
    {
      $birthday = date_create_from_format('d/m/Y', $data["birthday"]);
      $birthDate = explode("/", $data["birthday"]);
      $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[0], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
      $user->setBirthday($data["birthday"]);
      $user->setAge($age);
    }
    if (isset($data['gender']) && ($data['gender'] == "female" || $data['gender'] == "male"))
      $user->setGender($data['gender']);
    if (isset($data['lastname']))
      $user->setLastname($data['lastname']);
    if (isset($data['firstname']))
      $user->setFirstname($data['firstname']);

    $em = $this->getDoctrine()->getManager();
    $em->persist($user);
    $em->flush();

    return new Response (json_encode(array('message' => 'Informations modifiées')));
  }

  /**
  * @ApiDoc(
  *  section="Utilisateurs",
  *  resource=false,
  *  description="Get user's followed rooms",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Get("/api/suit/")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function getFollowedRoomsAction(Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();

    $followedRooms = $user->getFollowedRooms();
    $serializer = $this->container->get('jms_serializer');
    $reports = $serializer->serialize($followedRooms, 'json');

    return new Response($reports);
  }

  /**
  * @ApiDoc(
  *  section="Utilisateurs",
  *  resource=false,
  *  description="Set user's profile image",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  *  parameters= {
  *      {"name"="file", "dataType"="file", "required"=true, "description"="File"}
  *   }
  * )
  * @Rest\Post("/api/profile/image/add")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function setUserImageAction(Request $request)
  {
    $user = $this->get('security.token_storage')->getToken()->getUser();
    $file = $request->files->get('file');

    $filename = "image_profile_".$user->getId();
    $path = $this->get('app.file_uploader')->upload($file, $filename, "user");

    $file = new File();
    $file->setPath($path);

    $em = $this->getDoctrine()->getManager();
    $em->persist($file);
    $user->setAvatar($file);
    $em->persist($user);
    $em->flush();

    return new Response (200);
  }

  /**
  * @ApiDoc(
  *  section="Utilisateurs",
  *  resource=false,
  *  description="Set user's profile image",
  *  statusCodes = {
  *      200 = "Ok",
  *      400 = "Une erreur s'est produite",
  *      401 = "Unauthorized"
  *  },
  * )
  * @Rest\Post("/test")
  * @Rest\View(serializerGroups={"Default", "detail"})
  */
  public function test(Request $request)
  {
    echo time();
    return new Response (200);
  }
}
