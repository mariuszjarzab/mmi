<?php

/**
 * Mmi Framework (https://github.com/milejko/mmi.git)
 * 
 * @link       https://github.com/milejko/mmi.git
 * @copyright  Copyright (c) 2010-2017 Mariusz Miłejko (mariusz@milejko.pl)
 * @license    https://en.wikipedia.org/wiki/BSD_licenses New BSD License
 */

namespace Mmi\Http;

/**
 * Klasa odpowiedzi aplikacji
 */
class Response
{

    /**
     * Przechowuje nagłówki
     * @var ResponseHeader[]
     */
    private $_headers = [];

    /**
     * Przechowuje content
     * @var string
     */
    private $_content;

    /**
     * Włączony debugger
     * @var boolean
     */
    private $_debug = false;

    /**
     * Typ odpowiedzi
     * @var string
     */
    private $_type = 'text/html';

    /**
     * Kod odpowiedzi
     * @var integer
     */
    private $_code = 200;

    /**
     * Ustawia debugowanie
     * @param type $debug
     * @return \Mmi\Http\Response
     */
    public function setDebug($debug = true)
    {
        //ustawianie debugowania
        $this->_debug = (bool) $debug;
        //zwrot siebie
        return $this;
    }

    /**
     * Ustawia nagłówek
     * @param string $name nazwa
     * @param string $value wartość
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setHeader($name, $value = null, $replace = false)
    {
        //dodawanie obiektu nagłówka
        $this->_headers[] = (new ResponseHeader())
            ->setName($name)
            ->setValue($value)
            ->setReplace((bool) $replace);
        //zwrot siebie
        return $this;
    }

    /**
     * Ustawia kod odpowiedzi
     * @param int $code kod
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setCode($code, $replace = false)
    {
        //kod nie istnieje
        if (!($message = ResponseTypes::getMessageByCode($code))) {
            throw new HttpException('HTTP code not found');
        }
        //zapis kodu
        $this->_code = $code;
        //wysłanie nagłówka z kodem
        return $this->setHeader('HTTP/1.1 ' . $code . ' ' . $message, null, $replace);
    }

    /**
     * Ustawia kod na 404
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setCodeNotFound($replace = false)
    {
        //404
        return $this->setCode(404, $replace);
    }

    /**
     * Ustawia kod na 200
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setCodeOk($replace = false)
    {
        //200
        return $this->setCode(200, $replace);
    }

    /**
     * Ustawia kod na 500
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setCodeError($replace = false)
    {
        //500
        return $this->setCode(500, $replace);
    }

    /**
     * Ustawia kod na 401
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setCodeUnauthorized($replace = false)
    {
        //401
        return $this->setCode(401, $replace);
    }

    /**
     * Ustawia kod na 403
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setCodeForbidden($replace = false)
    {
        //403
        return $this->setCode(403, $replace);
    }

    /**
     * Ustawia typ kontentu odpowiedzi (content-type
     * @param string $type nazwa typu np. jpg, gif, html, lub text/html
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setType($type, $replace = false)
    {
        //usuwanie typu odpowiedzi
        $this->_type = ResponseTypes::searchType($type);
        //wysłanie nagłówka
        return $this->setHeader('Content-type', $this->_type, $replace);
    }

    /**
     * Zwraca typ odpowiedzi
     * @return string
     */
    public function getType()
    {
        //zwrot typu
        return $this->_type;
    }

    /**
     * Zwraca kod odpowiedzi
     * @return string
     */
    public function getCode()
    {
        //zwrot kodu
        return $this->_code;
    }

    /**
     * Ustawia typ na HTML
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setTypeHtml($replace = false)
    {
        //html
        return $this->setType('html', $replace);
    }

    /**
     * Ustawia typ na JSON
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setTypeJson($replace = false)
    {
        //json
        return $this->setType('json', $replace);
    }

    /**
     * Ustawia typ na JS
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setTypeJs($replace = false)
    {
        //js
        return $this->setType('js', $replace);
    }

    /**
     * Ustawia typ na Plain
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setTypePlain($replace = false)
    {
        //txt
        return $this->setType('txt', $replace);
    }

    /**
     * Ustawia typ na XML
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setTypeXml($replace = false)
    {
        //xml
        return $this->setType('xml', $replace);
    }

    /**
     * Ustawia typ na obraz PNG
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setTypePng($replace = false)
    {
        //png
        return $this->setType('png', $replace);
    }

    /**
     * Ustawia typ na obraz Jpeg
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setTypeJpeg($replace = false)
    {
        //jpeg
        return $this->setType('jpeg', $replace);
    }

    /**
     * Ustawia typ na Gzip
     * @param boolean $replace zastąpienie
     * @return \Mmi\Http\Response
     */
    public function setTypeGzip($replace = false)
    {
        //gzip
        return $this->setType('gz', $replace);
    }

    /**
     * Ustawia content do wysyłki
     * @param string $content zawartość
     * @return \Mmi\Http\Response
     */
    public function setContent($content)
    {
        $this->_content = (string) $content;
        return $this;
    }

    /**
     * Pobiera content
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Pobiera nagłówki
     * @return ResponseHeader[]
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Wysyła dane do klienta
     */
    public function send()
    {
        //iteracja po nagłówkach
        foreach ($this->_headers as $header) {
            try {
                //wysłanie nagłówka
                $header->send();
            } catch (\Mmi\App\KernelException $e) {
                //logowanie błędu
                \Mmi\App\FrontController::getInstance()->getLogger()->warning('Unable to send header: ' . $header->getName() . ' with value ' . $header->getValue());
            }
        }
        //opcjonalne uruchomienie panelu deweloperskiego
        if ($this->_debug) {
            //debugger wykonuje zmianę w contencie
            new \Mmi\Http\ResponseDebugger;
        }
        //zwrot contentu
        echo $this->_content;
    }

    /**
     * Przekierowuje na moduł, kontroler, akcję z parametrami
     * @param string $module moduł
     * @param string $controller kontroler
     * @param string $action akcja
     * @param array $params parametry
     * @param boolean $reset reset parametrów z URL - domyślnie włączony
     */
    public function redirect($module, $controller = null, $action = null, array $params = [], $reset = true)
    {
        //jeśli włączone resetowanie parametrów
        if (!$reset) {
            //parametry z requestu front controllera
            $requestParams = \Mmi\App\FrontController::getInstance()->getRequest()->toArray();
            //łączenie z parametrami z metody
            $params = array_merge($requestParams, $params);
        }
        //jeśli istnieje akcja
        if ($action !== null) {
            $params['action'] = $action;
        }
        //jeśli istnieje kontroler
        if ($controller !== null) {
            $params['controller'] = $controller;
        }
        //ustawienie modułu
        $params['module'] = $module;
        //przekierowanie na routę
        $this->redirectToRoute($params);
    }

    /**
     * Przekierowuje na url wygenerowany z parametrów, przez router
     * @param array $params parametry
     */
    public function redirectToRoute(array $params = [])
    {
        //przekierowanie na url
        $this->redirectToUrl(\Mmi\App\FrontController::getInstance()->getRouter()->encodeUrl($params));
    }

    /**
     * Przekierowanie na dowolny URL
     * @param string $url adres url
     */
    public function redirectToUrl($url)
    {
        //przekierowanie - header location
        (new ResponseHeader)->setName('Location')
            ->setValue($url)
            ->sendAndExit();
    }

}
