<?php

namespace model;

use PDO;
use service\Connection;

class Agenzia
{
    public function getAgenzie() {
        /** @var $pdo PDO */
        $pdo = Connection::getConnection();
        $statment = $pdo->prepare("SELECT Email, id FROM agenzia");
        $statment->execute();
        $result = $statment->setFetchMode(PDO::FETCH_ASSOC);
        if (!$result)
            throw new \Exception("error");
        return $statment->fetchAll();
    }
}