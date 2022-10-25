
 <?php
class InfosimplesApi
{


  public function consultaApi(){
    // $url = "https://api.infosimples.com/api/v2/consultas/receita-federal/pgfn/";
    // $cpf_cnpj='04694573500';
    // $headerApi=array(
    //   "Content-type"=>"application/json",
    //   "cpf_cnpj"=> $cpf_cnpj,
    //   "preferencia_emissao"=>'2via',
    //   "token"=>"Pt6FV_V4hxXClNfFDMJdo2CsPE9FPB69B3UQV6Zp"
    //  );
  
    // $result = $this->doPost($url, $headerApi);

    // //  $ch=curl_init($url);
    // //  curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); //converter para array
    // //  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE); //verifica ssl
    // //  curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"GET");
    // //  $resultado = json_decode(curl_exec($ch));
    // // dd($resultado);

    // //  foreach($resultado->results as $people){
    // //  echo "Nome é ".$people->name."<br>";
    // //  echo "<hr>";
    // // <?php curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml")); ?;

 echo "estou aqui";
   
  } 




  function doPost($url, $fields)
  {
    $fields = (is_array($fields)) ? http_build_query($fields) : $fields;

    if($ch = curl_init($url))
    {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length:' . strlen($fields,'Content-type:application/json')));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $resultado = json_decode(curl_exec($ch));

        dd($resultado);
      
      $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return (int) $status;
    }
    else
    {
        return false;
    }
  }



// if(doPost('http://example.com/api/a/b/c', array('foo' => 'bar')) == 200);
//    // do something
// else
//   echo "false";


} 
