<?php

namespace model;

use PDO;
use service\Connection;

class Questionario
{
    public function saveQuestionario($data, $questions) {
        try {
            /** @var $pdo PDO */
            $pdo = Connection::getConnection();
            if ($pdo->beginTransaction()) {
                $anagraficalStatment = $pdo->prepare("INSERT into questionario (NumeroDipendenti, PacVenduti, Anno, FK_Agenzia) value (:nd, :pv, :a, :fk)");
                $anagraficalStatment->execute(["nd" => $data["numDipe"], "pv" => $data["pacSale"], "a" => $data["pacYear"], "fk" => $data["FK_Agenzia"]]);
                $qgid = $pdo->lastInsertId();
                $genParams = [];
                $genValue = [];
                foreach ($questions["gen"] as $gen) {
                    $id = "gen".$gen["ID"];
                    $d = "d".$id;
                    $fk_d = "fk_d".$id;
                    $fk_g = "fk_g".$id;
                    $genParams[] = "(:".$d.", :".$fk_d.", :".$fk_g.")";
                    $genValue = array_merge($genValue, [$d => $data[$id], $fk_d => $gen["ID"], $fk_g => $qgid]);
                }
                $pacStatment = $pdo->prepare("INSERT into rispostegen (Descrizione, FK_domandegen, FK_questionario) values " . implode(", ", $genParams));
                $pacStatment->execute($genValue);
                $pacParams = [];
                $pacValue = [];
                foreach ($questions["pac"] as $pac) {
                    $id = "pac".$pac["ID"];
                    $d = "d".$id;
                    $fk_d = "fk_d".$id;
                    $fk_g = "fk_g".$id;
                    $pacParams[] = "(:".$d.", :".$fk_d.", :".$fk_g.")";
                    $pacValue = array_merge($pacValue, [$d => $data[$id], $fk_d => $pac["ID"], $fk_g => $qgid]);
                }
                $pacStatment = $pdo->prepare("INSERT into rispostepac (Descrizione, FK_domandepac, FK_questionario) values " . implode(", ", $pacParams));
                $pacStatment->execute($pacValue);
                $pdo->commit();
            }
        }catch (PDOException $PDOException){
            return false;
        }
    }

    public function getQuestions() {
        /** @var $pdo PDO */
        $pdo = Connection::getConnection();
        $statment = $pdo->prepare("SELECT * FROM domandegen");
        $statment->execute();
        $result = $statment->setFetchMode(PDO::FETCH_ASSOC);
        if (!$result)
            throw new \Exception("error");
        $data["gen"] = $statment->fetchAll();
        $data["gen-answers"] = [1, 2, 3, 4, 5];
        $statment = $pdo->prepare("SELECT * FROM domandepac");
        $statment->execute();
        $result = $statment->setFetchMode(PDO::FETCH_ASSOC);
        if (!$result)
            throw new \Exception("error");
        $data["pac"] = $statment->fetchAll();
        $data["pac-answers"] = [["value" => 1, "label" => "True"], ["value" => 0, "label" => "False"]];
        return $data;
    }

    public function getAgenzia($id) {
        /** @var $pdo PDO */
        $pdo = Connection::getConnection();
        $statment = $pdo->prepare("SELECT * FROM agenzia where id=:id");
        $statment->execute([":id" => $id]);
        $result = $statment->setFetchMode(PDO::FETCH_ASSOC);
        if (!$result)
            throw new \Exception("error");
        return $statment->fetch();
    }
}