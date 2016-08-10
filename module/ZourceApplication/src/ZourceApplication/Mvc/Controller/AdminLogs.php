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
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use ZourceApplication\Paginator\Adapter\CsvStream;

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
            if (preg_match('/daemon.([0-9]{4}-[0-9]{2}-[0-9]{2}).csv/', $item->getBasename(), $matches)) {
                $result[$matches[1]] = $this->loadCsvLog($item->getPathname());
            }
        }

        ksort($result);

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
            if (preg_match('/php_log.([0-9]{4}-[0-9]{2}-[0-9]{2}).csv/', $item->getBasename(), $matches)) {
                $result[$matches[1]] = $this->loadCsvLog($item->getPathname());
            }
        }

        return new ViewModel([
            'dayLogs' => $result,
        ]);
    }

    public function downloadDaemonAction()
    {
        $date = $this->params('date');
        $path = sprintf('data/logs/daemon.%s.xml', $date);

        $response = new Stream();
        $response->setStream(fopen($path, 'r'));
        $response->setCleanup(false);
        $response->setStatusCode(200);

        $headers = $response->getHeaders();
        $headers->addHeaderLine(sprintf('Content-Disposition: attachment; filename="daemon-%s.csv"', $date));
        $headers->addHeaderLine('Content-Type: text/csv');

        return $response;
    }

    public function downloadErrorsAction()
    {
        $date = $this->params('date');
        $path = sprintf('data/logs/php_log.%s.xml', $date);

        $response = new Stream();
        $response->setStream(fopen($path, 'r'));
        $response->setCleanup(false);
        $response->setStatusCode(200);

        $headers = $response->getHeaders();
        $headers->addHeaderLine(sprintf('Content-Disposition: attachment; filename="log-%s.csv"', $date));
        $headers->addHeaderLine('Content-Type: text/csv');

        return $response;
    }

    public function deleteDaemonAction()
    {
        $path = sprintf('data/logs/daemon.%s.csv', $this->params('date'));

        if (is_file($path)) {
            unlink($path);
        }

        return $this->redirect()->toRoute('admin/system/logs/daemon');
    }

    public function deleteErrorsAction()
    {
        $path = sprintf('data/logs/php_log.%s.csv', $this->params('date'));

        if (is_file($path)) {
            unlink($path);
        }

        return $this->redirect()->toRoute('admin/system/logs/errors');
    }

    private function loadCsvLog($path)
    {
        $result = [];

        $stream = fopen($path, 'r');

        while (!feof($stream)) {
            $data = fgetcsv($stream, null, ';');

            if ($data) {
                $result[] = [
                    'timestamp' => $data[0],
                    'priority' => $data[1],
                    'priorityName' => $data[2],
                    'message' => $data[3],
                    'extra' => json_decode($data[4], true),
                ];
            }
        }

        fclose($stream);

        return $result;
    }
}
