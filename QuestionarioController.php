<?php

namespace Controller;
use model\Agenzia;
use DateTime;
use JetBrains\PhpStorm\Pure;
use model\Questionario;
use service\Template;
use tokenService;

class QuestionarioController
{
    public function index(){
        $authentication = \service\Questionario::checkAuthentication();
        if (!$authentication)
            return http_response_code(400);

        $questionario = new Questionario();
        $questions = $questionario->getQuestions();
        $agenzia = $questionario->getAgenzia($authentication["id"]);
        $errors = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            $fields = ["pacYear", "numDipe", "pacSale"];
            foreach ($questions["gen"] as $question)
                $fields[] = "gen" . $question["ID"];
            foreach ($questions["pac"] as $question)
                $fields[] = "pac" . $question["ID"];

            $formData = ["FK_Agenzia" => $authentication["id"]];
            foreach ($fields as $field) {
                if (!isset($_POST[$field])){
                    $errors[$field] = "Il {$field} è obbligatorio";
                }else{
                    $formData[$field] = $this->test_input($_POST[$field]);
                }
            }

            if (empty($errors)) {
                $questionario = new Questionario();
                $questionario->saveQuestionario($formData, $questions);
            }
        }

        $data = [
            "agenzia" => $agenzia,
            "questions" => $questions
        ];
        if (!empty($errors))
            $data["errors"] = $errors;
        Template::render("questionario", $data);
    }

    public function sendMail() {
        $agenzieModel = new Agenzia();
        $agenzie = $agenzieModel->getAgenzie();
        $expires = new DateTime("now + 3 day");
        foreach ($agenzie as $agenzia) {
            $data = array(
                "id" => $agenzia["id"],
                "expires" => $expires->getTimestamp()
            );
            $token = urlencode(tokenService::encrypt($data));
            $message = "si prega gentilmente di compilare il seguente <a href='http://localhost/questionario?token={$token}'>questionario</a> e grazie";

            $to = $agenzia["Email"];
            $subject = 'account validation';
            $from = 'admin@myEmailClient.com';

            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            $headers .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            if (mail($to, $subject, $message, $headers)) {
                echo 'mail ' . $to . ' has been sent successfully.'."<br>";
            } else {
                echo 'mail ' . $to . ' has not been sent successfully.'."<br>";
            }
        }
    }

    protected function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}