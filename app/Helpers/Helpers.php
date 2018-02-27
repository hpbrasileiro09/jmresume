<?php

namespace App\Helpers;

use App\Pusher;

use App\Associated;

use Mail;

class Helpers {

    public function getIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    public function inverteData($data, $hour=0){
        if(count(explode("/",$data)) > 1){
            return implode("-",array_reverse(explode("/",$data))) . ($hour == 0 ? ' 00:00:00' : ' 23:59:59');
        }elseif(count(explode("-",$data)) > 1){
            return implode("/",array_reverse(explode("-",$data))) . ($hour == 0 ? ' 00:00:00' : ' 23:59:59');
        }
    }

    public function getLabelColor($x=0) 
    {
        $colors[] = 'primary';
        $colors[] = 'default';
        $colors[] = 'success';
        $colors[] = 'info';
        $colors[] = 'warning';
        $colors[] = 'danger';
        return $colors[$x];
    }

    public function getPublished() 
    {
        $published[] = Array( 'value' => 0, 'label' => 'No' );
        $published[] = Array( 'value' => 1, 'label' => 'Yes' );
        return $published;
    }

    public function getType() 
    {
        $type[] = Array( 'value' => 'news', 'label' => 'notícia' );
        $type[] = Array( 'value' => 'notification', 'label' => 'notificação' );
        return $type;
    }

    public function transRole($origem) {
        foreach($this->getRole() as $item) {
            if ($origem == $item['value']) {
                return $item['label'];
            }
        }
        return $origem;
    }

    public function transType($origem) {
        foreach($this->getType() as $item) {
            if ($origem == $item['value']) {
                return $item['label'];
            }
        }
        return $origem;
    }

    public function getRole() 
    {
        $role[] = Array( 'value' => 'admin', 'label' => 'administrador' );
        $role[] = Array( 'value' => 'associated', 'label' => 'associado' );
        return $role;
    }

    public function getColors() 
    {
        $color[] = 'danger';
        $color[] = 'info';
        $color[] = 'warning';
        $color[] = 'success';
        $color[] = 'primary';
        $color[] = 'default';
        return $color;
    }

    public function getColor($index) {
        $colors = $this->getColors();
        if ($index > count($colors)) $index = count($colors)-1;
        return $colors[$index];
    }

	public function RemoveAcento($string) {
	    return strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC");
	}

    public function antiSQL($string) {
        $string = strip_tags($string);
        $string = str_replace("'", "", $string);
        $string = str_replace("`", "", $string);
        $string = str_replace("--", "", $string);
        $string = str_replace("DROP ", "", $string);
        $string = str_replace("drop ", "", $string);
        $string = str_replace("SELECT ", "", $string);
        $string = str_replace("select ", "", $string);
        $string = str_replace("delete from ", "", $string);
        $string = str_replace("DELETE FROM ", "", $string);
        $string = str_replace("UPDATE ", "", $string);
        $string = str_replace("update ", "", $string);
        $string = addslashes($string);
        return $string;
    }

	public function get_client_ip() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if (getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if (getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if (getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if (getenv('HTTP_FORWARDED'))
	        $ipaddress = getenv('HTTP_FORWARDED');
	    else if (getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
	}

	public function limpaFone($string) {
	    $string = str_replace("(", "", $string);
	    $string = str_replace(")", "", $string);
	    $string = str_replace("-", "", $string);
	    $string = str_replace("/", "", $string);
	    $string = str_replace(" ", "", $string);
	    $string = str_replace("_", "", $string);
	    return trim($string);
	}

    public function dateToMysql($origem='', $hour=0) {
        $resp = date('Y-m-d H:i:s');
        if (strlen($origem) == 19) {
            $resp = substr($origem, 6, 4) . "-" . substr($origem, 3, 2) . "-" . substr($origem, 0, 2);
            if ($hour == 1) $resp .= " " . substr($origem, 11, 8);
        }
        return $resp;
    }

    public function mysqlToDate($origem='', $hour=0) {
        $resp = date('d-m-Y H:i:s');
        if (strlen($origem) == 19) {
            $resp = substr($origem, 8, 2) . "-" . substr($origem, 5, 2) . "-" . substr($origem, 0, 4); 
            if ($hour == 1) $resp .= " " . substr($origem, 11, 8);
        }
        return $resp;
    }

    public function mysqlToDateBr($origem='', $hour=0) {
        $resp = date('d-m-Y H:i:s');
        if (strlen($origem) == 19) {
            $resp = substr($origem, 8, 2) . "/" . substr($origem, 5, 2) . "/" . substr($origem, 0, 4); 
            if ($hour == 1) $resp .= " " . substr($origem, 11, 8);
        }
        return $resp;
    }

    public function getDataAdminLTE() {

        $data['messages'] = Array();
        $data['notifications'] = Array();
        $data['tasks'] = Array();
        return $data;

    }

    public function _getDataAdminLTE() {

        $data['messages'] = [
            [
                'id' => 1,
                'title' => 'Titulo 1',
                'content' => 'Titulo 1'
            ],
            [
                'id' => 2,
                'title' => 'Titulo 2',
                'content' => 'Titulo 2'
            ],
            [
                'id' => 3,
                'title' => 'Titulo 3',
                'content' => 'Titulo 3'
            ],
            [
                'id' => 4,
                'title' => 'Titulo 4',
                'content' => 'Titulo 4'
            ],
        ];
        $data['notifications'] = [
            [
                'id' => 1,
                'title' => 'Notificação 1',
                'content' => 'Notificação 1'
            ],
            [
                'id' => 2,
                'title' => 'Notificação 2',
                'content' => 'Notificação 2'
            ],
        ];
        $data['tasks'] = [
                [
                        'name' => 'Design New Dashboard',
                        'title' => 'Design New Dashboard',
                        'content' => 'Design New Dashboard',
                        'progress' => '87',
                        'color' => 'danger'
                ],
                [
                        'name' => 'Create Home Page',
                        'title' => 'Create Home Page',
                        'content' => 'Create Home Page',
                        'progress' => '76',
                        'color' => 'warning'
                ],
                [
                        'name' => 'Some Other Task',
                        'title' => 'Some Other Task',
                        'content' => 'Some Other Task',
                        'progress' => '32',
                        'color' => 'success'
                ],
                [
                        'name' => 'Start Building Website',
                        'title' => 'Start Building Website',
                        'content' => 'Start Building Website',
                        'progress' => '56',
                        'color' => 'info'
                ],
                [
                        'name' => 'Develop an Awesome Algorithm',
                        'title' => 'Develop an Awesome Algorithm',
                        'content' => 'Develop an Awesome Algorithm',
                        'progress' => '10',
                        'color' => 'success'
                ]
        ];

        return $data;

    }

    public function geraSenha($tamanho = 6, $maiusculas = false, $numeros = true, $simbolos = false)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';

        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;

        $len = strlen($caracteres);

        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }

        return $retorno;
    }

    public function enviarEmailBase($_type, $_to, $_cc, $_nome, $_subject, $_content, $_from=null) {

        $_resp = 'OK';

        try {

            $data = Array(
                'email' => $_to,
                'cc' => $_cc,
                'name' => $_nome,
                'subject' => $_subject,
                'content' => $_content,
                'from' => ($_from != null ? $_from : env('MAIL_FROM')),
            );

            Mail::send($_type, $data, function($message) use ($data) {
                $message->from($data['from'], 'Hpb Tecnologia');
                $message->to($data['email']);
                if (strlen($data['cc'])) $message->cc($data['cc']);
                $message->subject($data['subject']);
            });

            $_volta = Array(
                'resp' => $_resp,
                'email' => $_to,
            );

        } catch(Exception $e) {

            $_resp = 'NOK';

            $_volta = Array(
                'resp' => $_resp,
                'email' => $_to,
                'exception' => $e->getMessage(), 
            );

        }

        return $_resp;

    }

    public function enviarEmailBaseM($_type, $_to, $_cc, $_nome, $_subject, $_content, $_from=null) {

        $_resp = 'OK';

        $_headers = "MIME-Version: 1.1\n";
        $_headers .= "Content-type: text/html; charset=utf-8\n";
        $_headers .= "From: Sindiprol ADUEL<$_from>\n";
        if (strlen($_cc)) $_headers .= "Cc: $_cc\n";
        
        try {

            mail($_to, $_subject, $_content, $_headers);

            $_volta = Array(
                'resp' => $_resp,
                'email' => $_to,
            );

        } catch(Exception $e) {
    
            $_resp = 'NOK';

            $_volta = Array(
                'resp' => $_resp,
                'email' => $_to,
                'exception' => $e->getMessage(), 
            );

        }

        return $_resp;

    }

    public function sendpushnotification(
        $_content, 
        $_type = 'associateds', 
        $_associated_id = '0', 
        $_departments = ''
    ) {

        $_turn_on = true;

        if ($_content != "") {

            $regId = Array();
            $_geral = '0';
            $_selected = Array();

            switch($_type) {
            case "associateds":
                $_geral = $_associated_id;
                if ($_geral == '0') {
                    $associateds = Associated::all();
                    foreach($associateds as $_item) {
                        foreach($_item->keys as $_key) {
                            $regId[] = $_key['key'];
                            break;
                        }
                    }
                } else {
                    $associateds = Associated::where('id', $_geral)->get();
                    foreach($associateds as $_item) {
                        foreach($_item->keys as $_key) {
                            $regId[] = $_key['key'];
                            break;
                        }
                    }
                }
                break;
            case "selecteds":
                $associateds = Associated::where('marked', '=', '1')->get();
                foreach($associateds as $_item) {
                    foreach($_item->keys as $_key) {
                        $regId[] = $_key['key'];
                        break;
                    }
                }
                break;
            case "departments":
                $_postmeta = $_departments;
                if (strlen($_postmeta)) {
                    $_selected = explode(",",$_postmeta);
                    $associateds = Associated::whereIn('department_id', $_selected)->get();
                    foreach($associateds as $_item) {
                        foreach($_item->keys as $_key) {
                            $regId[] = $_key['key'];
                            break;
                        }
                    }
                }
                break;
            }

            if (count($regId)) {
                if ($_turn_on == true) {
                    $_pusher = new Pusher();
                    $_pusher->notify($regId, $_content);
                    \Storage::append('pusher.log', json_encode($_pusher->getOutputAsObject()));
                } else {
                    \Storage::append('pusher.log', json_encode([
                        'action' => 'DEBUG',
                        'content' => $_content,
                        'type'=> $_type, 
                        'associated_id' => $_associated_id, 
                        'departments'=> $_departments,
                        'count' => count($regId),
                    ]));
                }
            }

        } 

        return [
            'content' => $_content,
            'type'=> $_type, 
            'associated_id' => $_associated_id, 
            'departments'=> $_departments,
            'count' => count($regId),
        ];

    }

    public function setStatus($_temp, $_cor) {
        $resp = $_cor;
        if ($_temp) $resp = "grey";
        if ($_temp==2) $resp = "green";
        return $resp;
    }

    public function trataTexto($resp, $size=9)
    {
      return "<font style='font-size:".$size."px;'>" . $resp . "</font>";
    }

    public function trataValor($pvalor, $iblack=0)
    {
      $resp = number_format($pvalor, 2, ',', '.');
      $cor = "green";
      if ($pvalor < 0) $cor = "red";
      $cor = $this->setStatus($iblack, $cor);
      $_return = "<font style='float: right; font-size:11px;' color='" . $cor . "'>" . $resp . "</font>"; 
      if ($pvalor == 0) $_return = "<font style='float: right; font-size:11px;' color='" . $cor . "'>_</font>"; 
      return $_return;
    }

    public function trataValorC($pvalor)
    {
      $resp = number_format($pvalor, 2, ',', '.');
      return "<font style='float: right; font-size:9px;'>" . $resp . "</font>";
    }

    public function trataDDS($dia)
    {
      $resp = $dia;
      return "<font style='font-size:9px;'>" . $resp . "</font>";
    }

    public function trataDDS11($dia)
    {
      $resp = $dia;
      return "<font style='font-size:11px;'>" . $resp . "</font>";
    }

    public function trataDate($pdata)
    {
      $oDate = new DateTime($pdata);
      $resp = $oDate->format("d/m/Y");      
      return $resp;
    }

    public function getMonth($_month){

      $resp = "-";

      $_mat = Array();
      $_mat[] = Array( "label" => "Janeiro",   "id" => 1,  "desc" => "tem 31 dias" );
      $_mat[] = Array( "label" => "Fevereiro", "id" => 2,  "desc" => "tem 28 (ou 29 dias nos anos bissextos)" );
      $_mat[] = Array( "label" => "Mar&ccedil;o",     "id" => 3,  "desc" => "tem 31 dias" );
      $_mat[] = Array( "label" => "Abril",     "id" => 4,  "desc" => "tem 30 dias" );
      $_mat[] = Array( "label" => "Maio",      "id" => 5,  "desc" => "tem 31 dias" );
      $_mat[] = Array( "label" => "Junho",     "id" => 6,  "desc" => "tem 30 dias" );
      $_mat[] = Array( "label" => "Julho",     "id" => 7,  "desc" => "tem 31 dias" );
      $_mat[] = Array( "label" => "Agosto",    "id" => 8,  "desc" => "tem 31 dias" );
      $_mat[] = Array( "label" => "Setembro",  "id" => 9,  "desc" => "tem 30 dias" );
      $_mat[] = Array( "label" => "Outubro",   "id" => 10, "desc" => "tem 31 dias" );
      $_mat[] = Array( "label" => "Novembro",  "id" => 11, "desc" => "tem 30 dias" );
      $_mat[] = Array( "label" => "Dezembro",  "id" => 12, "desc" => "tem 31 dias" );

      foreach($_mat as $k => $v) {
        if ($v["id"] == $_month) {
          $resp = $v["label"];
          break;
        }
      }

      return "<font style='font-size:10px;'>" . utf8_encode($resp) . "</font>";

    }

    public function MontaCategories($mat, $label, $id_category, $_size=0)
    {
      $_width = '';
      if ($_size != 0) $_width = 'style="width: ' . $_size . 'px;"';
      $html = "";
      $html .= '<select ' . $_width . ' class="form-control" name="'.$label.'" id="'.$label.'" >';
      foreach ($mat as $v) {
        if ($id_category == $v['id']) {
          $html .= "<option selected=\"selected\" value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        } else {
          $html .= "<option value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        }
      }
      $html .= "</select>";
      return $html;
    }

    public function MontaIdCategory($mat, $id_category, $_size=0)
    {
      $_width = '';
      if ($_size != 0) $_width = 'style="width: ' . $_size . 'px;"';
      $html = "";
      $html .= '<select ' . $_width . ' class="form-control" name="id_category" id="id_category" placeholder="id_category">';
      foreach ($mat as $v) {
        if ($id_category == $v['id']) {
          $html .= "<option selected=\"selected\" value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        } else {
          $html .= "<option value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        }
      }
      $html .= "</select>";
      return $html;
    }

    public function MontaParcelas($mat, $times)
    {
      $html = "";
      $html .= '<select style="width: 200px;" class="form-control" name="times" id="times"  placeholder="times">';
      foreach ($mat as $v) {
        if ($times == $v['id']) {
          $html .= "<option selected=\"selected\" value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        } else {
          $html .= "<option value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        }
      }
      $html .= "</select>";
      return $html;
    }

    public function MontaCartoes($mat, $card)
    {
      $html = "";
      $html .= '<select style="width: 200px;" class="form-control" name="cards" id="cards" placeholder="cards">';
      foreach ($mat as $v) {
        if ($card == $v['id']) {
          $html .= "<option selected=\"selected\" value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        } else {
          $html .= "<option value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        }
      }
      $html .= "</select>";
      return $html;
    }

    public function MontaDrop($_label, $_mat, $_value)
    {
      $html = "";
      $html .= '<select style="width: 200px;" class="form-control" name="'.$_label.'" id="'.$_label.'" placeholder="'.$_label.'">';
      foreach ($_mat as $v) {
        if ($_value == $v['id']) {
          $html .= "<option selected=\"selected\" value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        } else {
          $html .= "<option value=\"" . $v['id'] . "\">" . $v['nome'] . "</option>";
        }
      }
      $html .= "</select>";
      return $html;
    } 

    public function MontaAlert($_col="12")
    {
        $_kind = session('kind', -1);
        $_msg = session('msg', "");

        $html = "";
        $_class = "";
        $_type = "";

        switch ($_kind) {
        case 1:
            $_class = "alert-success";
            $_type = "Well done!";
            break;
        case 2:
            $_class = "alert-info";
            $_type = "Heads up!";
            break;
        case 3:
            $_class = "alert-danger";
            $_type = "O snap!";
            break;
        case 4:
            $_class = "alert-warning";
            $_type = "Warning!";
            break;
        }

        if ($_kind != -1) {
            $html .= "<div class=\"row\">";
            $html .= "<div class=\"col-md-".$_col." col-sm-".$_col."\">";
            $html .= "<div id=\"message-alert\" class=\"alert alert-dismissable show ".$_class."\">";
            $html .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
            $html .= "<h4>".$_type."</h4>";
            $html .= "<p>". $_msg ."</p>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
        }

        session(['kind' => -1]);
        session(['msg' => ""]);

        return $html;
    }
    
    public function MontaSimNaoRB($label, $simnao, $slabel='')
    {
      $_checked = '';
      if ($simnao == 1) $_checked = 'checked="checked"'; 
      $html = "";
      $html .= '<div class="checkbox">';
      //$html .= '<div class="togglebutton">';
      $html .= '<label>';
      $html .= '<input type="checkbox" '.$_checked.' name="'.$label.'"  id="'.$label.'" value="'.$simnao.'">';
      $html .= '&nbsp;'.$slabel;
      $html .= '</label>';
      $html .= '</div>';

      return $html;
    }

}
