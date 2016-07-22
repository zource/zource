<?php
/**
 * This file is part of Zource. (https://github.com/zource/)
 *
 * @link https://github.com/zource/zource for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zource. (https://github.com/zource/)
 * @license https://raw.githubusercontent.com/zource/zource/master/LICENSE MIT
 */

namespace ZourceApplication\Mvc\Controller;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminLogs extends AbstractActionController
{
    public function daemonAction()
    {
        $result = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator('data/logs'),
            RecursiveIteratorIterator::SELF_FIRST
        );

        /** @var \SplFileInfo $item */
        foreach ($iterator as $item) {
            if (preg_match('/daemon.([0-9]{4}-[0-9]{2}-[0-9]{2}).xml/', $item->getBasename(), $matches)) {
                $result[$matches[1]] = $this->loadXmlLog($item->getPathname());
            }
        }

        return new ViewModel([
            'dayLogs' => array_reverse($result),
        ]);
    }

    public function errorsAction()
    {
        $result = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator('data/logs'),
            RecursiveIteratorIterator::SELF_FIRST
        );

        /** @var \SplFileInfo $item */
        foreach ($iterator as $item) {
            if (preg_match('/php_log.([0-9]{4}-[0-9]{2}-[0-9]{2}).xml/', $item->getBasename(), $matches)) {
                $result[$matches[1]] = $this->loadXmlLog($item->getPathname());
            }
        }

        return new ViewModel([
            'dayLogs' => array_reverse($result),
        ]);
    }

    public function downloadDaemonAction()
    {
        $date = $this->params('date');
        $path = sprintf('data/logs/daemon.%s.xml', $date);
        $xml = sprintf('<?xml version="1.0" ?><root>%s</root>', file_get_contents($path));

        $response = new Response();
        $response->setContent($xml);
        $response->setStatusCode(200);

        $headers = $response->getHeaders();
        $headers->addHeaderLine(sprintf('Content-Disposition: attachment; filename="daemon-%s.xml"', $date));
        $headers->addHeaderLine('Content-Type: text/xml');

        return $response;
    }

    public function downloadErrorsAction()
    {
        $date = $this->params('date');
        $path = sprintf('data/logs/php_log.%s.xml', $date);
        $xml = sprintf('<?xml version="1.0" ?><root>%s</root>', file_get_contents($path));

        $response = new Response();
        $response->setContent($xml);
        $response->setStatusCode(200);

        $headers = $response->getHeaders();
        $headers->addHeaderLine(sprintf('Content-Disposition: attachment; filename="log-%s.xml"', $date));
        $headers->addHeaderLine('Content-Type: text/xml');

        return $response;
    }

    public function deleteDaemonAction()
    {
        $path = sprintf('data/logs/daemon.%s.xml', $this->params('date'));

        if (is_file($path)) {
            unlink($path);
        }

        return $this->redirect()->toRoute('admin/system/logs/daemon');
    }

    public function deleteErrorsAction()
    {
        $path = sprintf('data/logs/php_log.%s.xml', $this->params('date'));

        if (is_file($path)) {
            unlink($path);
        }

        return $this->redirect()->toRoute('admin/system/logs/errors');
    }

    private function loadXmlLog($path)
    {
        $result = [];

        $xml = sprintf('<?xml version="1.0" ?><root>%s</root>', file_get_contents($path));
        $elements = new \SimpleXMLElement($xml);

        foreach ($elements as $log) {
            $result[] = json_decode(json_encode($log), TRUE);;
        }

        return array_reverse($result);
    }
}
