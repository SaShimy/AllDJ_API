<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        if (0 === strpos($pathinfo, '/music_type')) {
            // app_musictype_getmusictypes
            if ($pathinfo === '/music_type/types') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_musictype_getmusictypes;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\MusicTypeController::getMusicTypes',  '_route' => 'app_musictype_getmusictypes',);
            }
            not_app_musictype_getmusictypes:

            // app_musictype_addmusictype
            if ($pathinfo === '/music_type/add') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_musictype_addmusictype;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\MusicTypeController::addMusicType',  '_route' => 'app_musictype_addmusictype',);
            }
            not_app_musictype_addmusictype:

            // app_musictype_getmusictype
            if (0 === strpos($pathinfo, '/music_type/details') && preg_match('#^/music_type/details/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_musictype_getmusictype;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_musictype_getmusictype')), array (  '_controller' => 'AppBundle\\Controller\\MusicTypeController::getMusicType',));
            }
            not_app_musictype_getmusictype:

        }

        if (0 === strpos($pathinfo, '/playlist/api')) {
            // app_playlist_getuserplaylists
            if ($pathinfo === '/playlist/api/me') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_playlist_getuserplaylists;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\PlaylistController::getUserPlaylistsAction',  '_route' => 'app_playlist_getuserplaylists',);
            }
            not_app_playlist_getuserplaylists:

            // app_playlist_newplaylist
            if ($pathinfo === '/playlist/api/new') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_playlist_newplaylist;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\PlaylistController::newPlaylistAction',  '_route' => 'app_playlist_newplaylist',);
            }
            not_app_playlist_newplaylist:

            // app_playlist_addmusictoplaylist
            if (preg_match('#^/playlist/api/(?P<id>[^/]++)/music/add$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_playlist_addmusictoplaylist;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_playlist_addmusictoplaylist')), array (  '_controller' => 'AppBundle\\Controller\\PlaylistController::addMusicToPlaylistAction',));
            }
            not_app_playlist_addmusictoplaylist:

            // app_playlist_getplaylist
            if (preg_match('#^/playlist/api/(?P<id>[^/]++)/details$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_playlist_getplaylist;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_playlist_getplaylist')), array (  '_controller' => 'AppBundle\\Controller\\PlaylistController::getPlaylistAction',));
            }
            not_app_playlist_getplaylist:

            // app_playlist_removeplaylist
            if (preg_match('#^/playlist/api/(?P<id>[^/]++)/remove$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_playlist_removeplaylist;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_playlist_removeplaylist')), array (  '_controller' => 'AppBundle\\Controller\\PlaylistController::removePlaylistAction',));
            }
            not_app_playlist_removeplaylist:

            // app_playlist_removeplaylistmusic
            if (preg_match('#^/playlist/api/(?P<id>[^/]++)/music/(?P<id_music>[^/]++)/remove$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_playlist_removeplaylistmusic;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_playlist_removeplaylistmusic')), array (  '_controller' => 'AppBundle\\Controller\\PlaylistController::removePlaylistMusicAction',));
            }
            not_app_playlist_removeplaylistmusic:

        }

        if (0 === strpos($pathinfo, '/room')) {
            // app_room_getallrooms
            if ($pathinfo === '/room/all') {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_room_getallrooms;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\RoomController::getAllRoomsAction',  '_route' => 'app_room_getallrooms',);
            }
            not_app_room_getallrooms:

            // app_room_getroom
            if (0 === strpos($pathinfo, '/room/details') && preg_match('#^/room/details/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_app_room_getroom;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_room_getroom')), array (  '_controller' => 'AppBundle\\Controller\\RoomController::getRoomAction',));
            }
            not_app_room_getroom:

            if (0 === strpos($pathinfo, '/room/api')) {
                // app_room_newroom
                if ($pathinfo === '/room/api/new') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_room_newroom;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\RoomController::newRoomAction',  '_route' => 'app_room_newroom',);
                }
                not_app_room_newroom:

                // app_room_followroom
                if (preg_match('#^/room/api/(?P<id>[^/]++)/follow$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_room_followroom;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_room_followroom')), array (  '_controller' => 'AppBundle\\Controller\\RoomController::followRoomAction',));
                }
                not_app_room_followroom:

                // app_room_getroomwaitinglist
                if (preg_match('#^/room/api/(?P<id>[^/]++)/waiting_list$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_room_getroomwaitinglist;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_room_getroomwaitinglist')), array (  '_controller' => 'AppBundle\\Controller\\RoomController::getRoomWaitingListAction',));
                }
                not_app_room_getroomwaitinglist:

                // app_room_newroomwaitinglist
                if (preg_match('#^/room/api/(?P<id>[^/]++)/waiting_list/join$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_room_newroomwaitinglist;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_room_newroomwaitinglist')), array (  '_controller' => 'AppBundle\\Controller\\RoomController::newRoomWaitingListAction',));
                }
                not_app_room_newroomwaitinglist:

                // app_room_updateroomwaitinglistmusic
                if (preg_match('#^/room/api/(?P<id>[^/]++)/waiting_list/music/update$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_room_updateroomwaitinglistmusic;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_room_updateroomwaitinglistmusic')), array (  '_controller' => 'AppBundle\\Controller\\RoomController::updateRoomWaitingListMusicAction',));
                }
                not_app_room_updateroomwaitinglistmusic:

                // app_room_getroomactualmusic
                if (preg_match('#^/room/api/(?P<id>[^/]++)/music$#s', $pathinfo, $matches)) {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_room_getroomactualmusic;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_room_getroomactualmusic')), array (  '_controller' => 'AppBundle\\Controller\\RoomController::getRoomActualMusic',));
                }
                not_app_room_getroomactualmusic:

                // app_room_updateroomwaitinglist
                if (preg_match('#^/room/api/(?P<id>[^/]++)/music/update$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_room_updateroomwaitinglist;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_room_updateroomwaitinglist')), array (  '_controller' => 'AppBundle\\Controller\\RoomController::updateRoomWaitingListAction',));
                }
                not_app_room_updateroomwaitinglist:

                // app_room_leaveroomwaitinglist
                if (preg_match('#^/room/api/(?P<id>[^/]++)/waiting_list/leave$#s', $pathinfo, $matches)) {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_room_leaveroomwaitinglist;
                    }

                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_room_leaveroomwaitinglist')), array (  '_controller' => 'AppBundle\\Controller\\RoomController::leaveRoomWaitingListAction',));
                }
                not_app_room_leaveroomwaitinglist:

            }

        }

        if (0 === strpos($pathinfo, '/user')) {
            // app_user_createuser
            if ($pathinfo === '/user/signup') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_user_createuser;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\UserController::createUserAction',  '_route' => 'app_user_createuser',);
            }
            not_app_user_createuser:

            if (0 === strpos($pathinfo, '/user/api')) {
                if (0 === strpos($pathinfo, '/user/api/profile')) {
                    // app_user_getmyuser
                    if ($pathinfo === '/user/api/profile') {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_app_user_getmyuser;
                        }

                        return array (  '_controller' => 'AppBundle\\Controller\\UserController::getMyUserAction',  '_route' => 'app_user_getmyuser',);
                    }
                    not_app_user_getmyuser:

                    // app_user_getuser
                    if (preg_match('#^/user/api/profile/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                        if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                            $allow = array_merge($allow, array('GET', 'HEAD'));
                            goto not_app_user_getuser;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'app_user_getuser')), array (  '_controller' => 'AppBundle\\Controller\\UserController::getUserAction',));
                    }
                    not_app_user_getuser:

                }

                // app_user_updateuser
                if ($pathinfo === '/user/api/update') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_user_updateuser;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::updateUserAction',  '_route' => 'app_user_updateuser',);
                }
                not_app_user_updateuser:

                // app_user_getfollowedrooms
                if (rtrim($pathinfo, '/') === '/user/api/suit') {
                    if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                        $allow = array_merge($allow, array('GET', 'HEAD'));
                        goto not_app_user_getfollowedrooms;
                    }

                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'app_user_getfollowedrooms');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::getFollowedRoomsAction',  '_route' => 'app_user_getfollowedrooms',);
                }
                not_app_user_getfollowedrooms:

                // app_user_setuserimage
                if ($pathinfo === '/user/api/profile/image/add') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_app_user_setuserimage;
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\UserController::setUserImageAction',  '_route' => 'app_user_setuserimage',);
                }
                not_app_user_setuserimage:

            }

            // app_user_test
            if ($pathinfo === '/user/test') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_app_user_test;
                }

                return array (  '_controller' => 'AppBundle\\Controller\\UserController::test',  '_route' => 'app_user_test',);
            }
            not_app_user_test:

        }

        // nelmio_api_doc_index
        if (preg_match('#^/(?P<view>[^/]++)?$#s', $pathinfo, $matches)) {
            if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'HEAD'));
                goto not_nelmio_api_doc_index;
            }

            return $this->mergeDefaults(array_replace($matches, array('_route' => 'nelmio_api_doc_index')), array (  '_controller' => 'Nelmio\\ApiDocBundle\\Controller\\ApiDocController::indexAction',  'view' => 'default',));
        }
        not_nelmio_api_doc_index:

        // fos_oauth_server_token
        if ($pathinfo === '/oauth/v2/token') {
            if (!in_array($this->context->getMethod(), array('GET', 'POST', 'HEAD'))) {
                $allow = array_merge($allow, array('GET', 'POST', 'HEAD'));
                goto not_fos_oauth_server_token;
            }

            return array (  '_controller' => 'fos_oauth_server.controller.token:tokenAction',  '_route' => 'fos_oauth_server_token',);
        }
        not_fos_oauth_server_token:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
