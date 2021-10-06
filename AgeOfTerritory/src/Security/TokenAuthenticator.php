<?php
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator {

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }


    /* Cela sera appelé à chaque demande et votre travail consiste à décider si
     * l'authentificateur doit être utilisé pour cette demande (retour true)
     * ou s'il doit être ignoré (retour false).
     */
    public function supports(Request $request){
         return $request->headers->has('X-AUTH-TOKEN');
    }


    /* Ce sera appelé à chaque demande et votre travail consiste à lire le jeton
     *(ou quelle que soit votre information "d'authentification") à partir de la demande
     * et à le renvoyer. Ces informations d'identification sont ensuite transmises en tant que premier
     * argument de getUser().
     */
    public function getCredentials(Request $request){
        return [
            'token' => $request->headers->get('X-AUTH-TOKEN'),
        ];
    }


    /*credentials est la valeur renvoyée par getCredentials(). Votre travail consiste à renvoyer un objet
     *à implémenter UserInterface. Si vous le faites, alors checkCredentials()sera appelé. Si vous renvoyez null
     *(ou lancez une AuthenticationException ), l'authentification échouera.
     */
    public function getUser($credentials, UserProviderInterface $userProvider){
        $apiToken = $credentials['token'];

        if (null === $apiToken) {
            return;
        }
        // if a User object, checkCredentials() is called
            return $this->em->getRepository(User::class)
                        ->findOneBy(['apiToken' => $apiToken]);
    }


    /* Si getUser()renvoie un objet User, cette méthode est appelée. Votre travail consiste à vérifier
     * si les informations d'identification sont correctes. Pour un formulaire de connexion, c’est ici que
     * vous devez vérifier que le mot de passe est correct pour l’utilisateur. Pour réussir l'authentification,
     *retournez  true. Si vous retournez quelque chose d' autre (ou lancez une AuthenticationException ),
     *l'authentification échouera.
     */
    public function checkCredentials($credentials, UserInterface $user){
        return true;
    }


    /*Ceci est appelé après une authentification réussie et votre travail consiste à renvoyer un Responseobjet
     * qui sera envoyé au client ou nullà poursuivre la demande (par exemple, autoriser l'appel de la route /
     * du contrôleur comme d'habitude). Comme il s'agit d'une API dans laquelle chaque demande s'authentifie,
     *  vous souhaitez la renvoyer  null.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey){
        return null;
    }


    /* Ceci est appelé si l'authentification échoue. Votre travail consiste à renvoyer l' Response objet
     * à envoyer au client. Le $exceptionvous dira ce qui ne va pas pendant l'authentification.
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception){
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }


    /* Ceci est appelé si le client accède à un URI / ressource nécessitant une authentification, mais qu'aucun
     * détail d'authentification n'a été envoyé. Votre travail consiste à renvoyer un  Responseobjet qui
     * aide l'utilisateur à s'authentifier (par exemple, une réponse 401 indiquant "le jeton est manquant!").
     */
    public function start(Request $request, AuthenticationException $authException = null){

    $data = [
        'message' => 'Authentication Required'
    ];

    return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }


    /* Si vous souhaitez prendre en charge la fonctionnalité "Remember me", renvoyez true à partir de cette
     * méthode. Vous aurez toujours besoin d'activer remember_mesous votre pare-feu pour que cela fonctionne.
     * S'agissant d'une API sans état, vous ne souhaitez pas prendre en charge la fonctionnalité
     * "souvenez-vous de moi" dans cet exemple.
     */
    public function supportsRememberMe(){
        return false;
    }
}
