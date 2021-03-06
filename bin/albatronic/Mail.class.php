<?php

/**
 * Clase para envíos de correos electrónicos
 * 
 * Está implementado para ser independiente del motor de envíos
 * Si el constructor recibe un objeto mailer, lo utiliza, en caso contrario
 * lo instancia en base a los parametros indicados en el nodo 'mailer'
 * del archivo de configuracion 'config/config.yml' donde por defecto
 * se utiliza la clase PHPMailer_v2.0.0
 *
 * Métodos Públicos:
 *
 *  send($para,$de,$deNombre,$asunto,$mensaje, array $adjuntos): envía el email
 *  compruebaEmail($email): comprueba la validez sintáctica del $email
 * 
 * @author Sergio Perez. <sergio.perez@albatronic.com>
 * @copyright Informática ALBATRONIC, SL
 * @since 29.05.2011
 */
class Mail {

    private $mailer;
    private $mensaje = null;

    public function __construct($mailer = '') {
        if (is_object($mailer))
            $this->mailer = $mailer;
        elseif (is_array($mailer)) {
            // Busco el motor para enviar correos, que debe estar
            // indicado en el nodo 'mailer' del fichero de configuracion
            //$config = sfYaml::load('config/config.yml');
            //$config = $config['config']['mailer'];

            // Cargo la clase
            if (file_exists($mailer['plugin_dir'] . $mailer['plugin_file'])) {
                include_once $mailer['plugin_dir'] . $mailer['plugin_file'];
                //include_once $mailer['plugin_dir'] . "class.pop3.php";

                //$pop = new POP3();
                //$pop->Authorise($mailer['host'], $mailer['port'], (double) $mailer['timeout'], $mailer['user_name'], $mailer['password'], 1);
                // Instancio un objeto de la clase mailer. La clase que se utilizará
                // debe estar indicada en el subnodo 'motor' del nodo 'mailer'
                $this->mailer = new $mailer['motor']();

                // Cargo los parametros que necesita el objeto mailer
                //$this->mailer->IsSMTP();
                $this->mailer->IsMail();
                $this->mailer->SMTPDebug = 1;
                $this->mailer->PluginDir = $mailer['plugin_dir'];
                $this->mailer->Mailer = $mailer['socket'];
                $this->mailer->Host = $mailer['host'];
                $this->mailer->SMTPAuth = $mailer['smtp_auth'];
                $this->mailer->Port = $mailer['port'];
                //$this->mailer->SMTPSecure = "tls";
                $this->mailer->Username = $mailer['user_name'];
                $this->mailer->Password = $mailer['password'];
                $this->mailer->Timeout = (double) $mailer['timeout'];
                $this->mailer->From = $mailer['from'];
                $this->mailer->FromName = $mailer['from_name'];
                $this->mailer->setLanguage(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2), $config['plugin_dir'] . "language/");
            } else
                $this->mensaje = "Error: no se ha podido crear el objeto mailer.";
        } else
            $this->mensaje = "Error: no se ha definido el soporte para enviar correos.";
    }

    /**
     * Envia un email
     *
     * @param email_adress $para La dirección del destinatario
     * @param email_adress $de La dirección del remitente
     * @param string $deNombre El nombre del remitente
     * @param string $asunto El texto del asunto
     * @param string $mensaje El texto de mensaje
     * @param array $adjuntos Array con los nombres de los ficheros adjuntos
     * @return string Mensaje de exito o fracaso al enviar
     */
    public function send($para, $de, $deNombre, $asunto, $mensaje, array $adjuntos) {

        if ($this->valida($para, $mensaje)) {
            if (trim($de) != '')
                $this->mailer->From = $de;
            if (trim($deNombre) != '')
                $this->mailer->FromName = $deNombre;

            $this->mailer->AddAddress($para);
            foreach ($adjuntos as $adjunto) {
                $this->mailer->AddAttachment($adjunto);
            }
            $this->mailer->Subject = trim($asunto);
            $this->mailer->Body = trim($mensaje);
            $this->mailer->IsHTML(true);

            if (!$this->mailer->Send())
                $this->mensaje = "Error en el envio: " . $this->mailer->ErrorInfo;
        }
        return ($this->mensaje == null);
    }

    /**
     * Comprueba que los parámetros sean válidos
     * Devuelve TRUE si es correcto
     *
     * @param email_address $email
     * @param string $contenido
     * @return boolean TRUE si es correcto
     */
    private function valida($email, $contenido) {
        if (!$this->compruebaEmail($email))
            $this->mensaje = "La direccion email indicada no es valida";
        if (trim($contenido) == "")
            $this->mensaje = "No ha indicado ningun contenido.";

        return ($this->mensaje == null);
    }

    /**
     * Comprueba la validez sintáctica de un email
     * Devuelve true o false
     *
     * @param string $email El correo electrónico
     * @return boolean
     */
    public function compruebaEmail($email) {
        $mail_correcto = 0;
        //compruebo unas cosas primeras
        if ((strlen($email) >= 6) && (substr_count($email, "@") == 1) && (substr($email, 0, 1) != "@") && (substr($email, strlen($email) - 1, 1) != "@")) {
            if ((!strstr($email, "'")) && (!strstr($email, "\"")) && (!strstr($email, "\\")) && (!strstr($email, "\$")) && (!strstr($email, " "))) {
                //miro si tiene caracter .
                if (substr_count($email, ".") >= 1) {
                    //obtengo la terminacion del dominio
                    $term_dom = substr(strrchr($email, '.'), 1);
                    //compruebo que la terminación del dominio sea correcta
                    if (strlen($term_dom) > 1 && strlen($term_dom) < 5 && (!strstr($term_dom, "@"))) {
                        //compruebo que lo de antes del dominio sea correcto
                        $antes_dom = substr($email, 0, strlen($email) - strlen($term_dom) - 1);
                        $caracter_ult = substr($antes_dom, strlen($antes_dom) - 1, 1);
                        if ($caracter_ult != "@" && $caracter_ult != ".") {
                            $mail_correcto = 1;
                        }
                    }
                }
            }
        }
        if ($mail_correcto)
            return true;
        else
            return false;
    }

    public function getError() {
        return $this->mensaje;
    }

}

?>
