<?php

class MainWebService extends WebService {

    public function root() {
        return __DIR__.'/';
    }

    public function requestUriWillDispatch($requestUri) {
        if (false !== strpos($requestUri, '/debug/')) {
            Dojet::v('is_debug', true);
            $requestUri = (string)substr($requestUri, strlen('/debug'));
        }
        $requestUri = parent::requestUriWillDispatch($requestUri);

        return $requestUri;
    }

}
