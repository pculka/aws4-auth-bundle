<?php

namespace PC\Aws4AuthBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
#use AppBundle\Security\Authentication\Token\WsseUserToken;

class Aws4Listener implements ListenerInterface
{
    protected $tokenStorage;
    protected $authenticationManager;

    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $authenticationManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }
    /**
     * This interface must be implemented by firewall listeners.
     *
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        // parse the request parts and create a new signature using the AWS client

        // $wsseRegex = '/UsernameToken Username="([^"]+)", PasswordDigest="([^"]+)", Nonce="([a-zA-Z0-9+/]+={0,2})", Created="([^"]+)"/';
        //$aws4Regex = '/Authorization: AWS4-HMAC-SHA256 Credential=AKIDEXAMPLE/20150830/us-east-1/iam/aws4_request, SignedHeaders=content-type;host;x-amz-date, Signature=5d672d79c15b13162d9279b0855cfba6789a8edb4c82c400e06b5924a6f2b5d7';
        //$aws4Regex = '/([^"]+) Credential=([^"]+), SignedHeaders=([^"]+), Signature=([a-z9-0^"]+)/';
        // AWS4-HMAC-SHA256 Credential=key1/20160418/us-east-1/S3/aws4_request, SignedHeaders=content-type;host;x-amz-date, Signature=9f48d763c1cb38c08d5ae52ea27043dca987a66d3b289fb3dedb606305fd9d55
        $aws4Regex = '/AWS4-HMAC-SHA256 Credential=(.+), SignedHeaders=([a-z\-;]+), Signature=([a-z0-9]+)/';


        if (!$request->headers->has('Authorization') || 1 !== preg_match($aws4Regex, $request->headers->get('Authorization'), $matches)) {
            return;
        }

        list($credential['key'], $credential['date'], $credential['zone'], $credential['service']) = explode('/', $matches[1]);
        $signedHeaders = explode(';', $matches[2]);
        $signature = $matches[3];

        //$password = ...;

        // By default deny authorization - we do not allow for authentication chains for now
        // if required, use OAUTH2 instead
        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $event->setResponse($response);
    }
}
