<?php

namespace PC\Aws4AuthBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
        $aws4Regex = '/AWS4-HMAC-SHA256 Credential=(.+), SignedHeaders=([a-z0-9\-;]+), Signature=([a-z0-9]+)/';

        // TODO: add also query string signature alternative (http://docs.aws.amazon.com/general/latest/gr/sigv4_signing.html)
        if (!$request->headers->has('Authorization') || 1 !== preg_match($aws4Regex, $request->headers->get('Authorization'), $matches)) {
            return;
        }

        list($credential['key'], $credential['date'], $credential['region'], $credential['service']) = explode('/', $matches[1]);
        $signedHeaders = explode(';', $matches[2]);
        $signature = $matches[3];

        // Task 1: create Canonical Request
        $originalHeaders = array();
        sort($signedHeaders, SORT_STRING);
        foreach ($signedHeaders as $signedHeader) {
            // todo: maybe add $ro = preg_replace('/\s+/', ' ',$row['message']);
            // though in in the request the signedHeaders should be properly trimmed already
            $originalHeaders[] = strtolower($signedHeader).':'.trim($request->headers->get($signedHeader));
        }
        // don't forget newline after implode, as the headers are key:value\n
        // therefore a newline exists at the end of the canonicalHeaders block in the canonicalRequest
        $canonicalHeaders = implode("\n", $originalHeaders)."\n";

        $parsedUrl = parse_url($request->getUri());
        $canonicalUri = (trim($parsedUrl['path']) == "")? "/" : $parsedUrl['path'];
        $canonicalQueryString = $request->getQueryString();
        $hashedPayload = strtolower(hash('sha256', $request->getContent()));
        $canonicalRequest =
            $request->getMethod()."\n".
            $canonicalUri."\n".
            $canonicalQueryString."\n".
            $canonicalHeaders."\n".
            implode(";", $signedHeaders)."\n".
            $hashedPayload
            ;
        $hashedCanonicalRequest = strtolower(hash('sha256', $canonicalRequest));
        // todo: check $hashedPayload == $request->headers->get('x-amz-content-sha256'));

        // Task 2: Create a String to Sign
        $stringToSign =
            "AWS4-HMAC-SHA256\n".
            $request->headers->get('x-amz-date')."\n".
            $credential['date'].'/'.$credential['region'].'/'.$credential['service'].'/aws4_request'."\n".
            $hashedCanonicalRequest
            ;

        // Task 3 : Calculate the AWS Signature
        // TODO: GET THE SECRET FROM THE USER WITH CREDENTIAL KEY
        $kSecret = 'wJalrXUtnFEMI/K7MDENG+bPxRfiCYEXAMPLEKEY';

        $kDate = hash_hmac("sha256", $credential['date'], "AWS4".$kSecret, true);
        $kRegion = hash_hmac("sha256", $credential['region'], $kDate, true);
        $kService = hash_hmac("sha256", $credential['service'], $kRegion, true);
        $kSigning = hash_hmac("sha256", "aws4_request", $kService, true); // this is the key we use to sign the request

        $calculatedSignature = hash_hmac("sha256", $stringToSign, $kSigning);

        if ($calculatedSignature == $signature) {
            // return the proper Token
        }

        // By default deny authorization - we do not allow for authentication chains for now
        // if required, use OAUTH2 instead
        $response = new Response();
        $response->setStatusCode(Response::HTTP_FORBIDDEN);
        $event->setResponse($response);
    }
}
