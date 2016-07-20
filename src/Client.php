<?php
namespace EduSoho\Beanstalk;

use Beanstalk\Client as BaseClient;

class Client extends BaseClient
{
    protected $_latestError;

    public function put($pri, $delay, $ttr, $data)
    {
        return $this->_execute('put', [$pri, $delay, $ttr, $data]);
    }

    public function useTube($tube)
    {
        return $this->_execute('useTube', [$tube]);
    }

    public function pauseTube($tube, $delay)
    {
        return $this->_execute('useTube', [$tube, $delay]);
    }

    public function reserve($timeout = null)
    {
        return $this->_execute('reserve', [$timeout]);
    }

    public function delete($id)
    {
        return $this->_execute('delete', [$id]);
    }

    public function release($id, $pri, $delay)
    {
        return $this->_execute('release', [$id, $pri, $delay]);
    }

    public function bury($id, $pri)
    {
        return $this->_execute('bury', [$id, $pri]);
    }

    public function touch($id)
    {
        return $this->_execute('touch', [$id]);
    }

    public function watch($tube)
    {
        return $this->_execute('watch', [$tube]);
    }

    public function ignore($tube)
    {
        return $this->_execute('ignore', [$tube]);
    }

    public function peek($id)
    {
        return $this->_execute('peek', [$id]);
    }

    public function peekReady()
    {
        return $this->_execute('peekReady', []);
    }

    public function peekDelayed()
    {
        return $this->_execute('peekDelayed', []);
    }

    public function peekBuried()
    {
        return $this->_execute('peekBuried', []);
    }

    public function kick($bound)
    {
        return $this->_execute('kick', [$bound]);
    }

    public function kickJob($id)
    {
        return $this->_execute('kickJob', [$id]);
    }

    public function statsJob($id)
    {
        return $this->_execute('statsJob', [$id]);
    }

    public function statsTube($tube)
    {
        return $this->_execute('statsTube', [$tube]);
    }

    public function stats()
    {
        return $this->_execute('stats', []);
    }

    public function listTubes()
    {
        return $this->_execute('listTubes', []);
    }

    public function listTubeUsed()
    {
        return $this->_execute('listTubeUsed', []);
    }

    public function listTubesWatched()
    {
        return $this->_execute('listTubesWatched', []);
    }

    public function getLatestError()
    {
        $error = $this->_latestError;
        $this->_latestError = null;
        return $error;
    }

    protected function _error($message)
    {
        parent::_error($message);
        $this->_latestError = $message;
    }

    protected function _execute()
    {
        $args = func_get_args();

        $result = call_user_func_array([$this, "parent::{$args[0]}"], $args[1]);
        if ($result !== false) {
            return $result;
        }

        $this->reconnect();
        return call_user_func_array([$this, "parent::{$args[0]}"], $args[1]);
    }

    protected function reconnect()
    {
        if ($this->_config['logger']) {
            $this->_config['logger']->warning('reconnect');
        }
        // fclose($this->_connection);
        $this->_connection = null;
        $this->connected = false;
        return $this->connect();
    }

}
