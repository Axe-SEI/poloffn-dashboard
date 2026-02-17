<?php
// Recebe os dados JSON do frontend
$data = json_decode(file_get_contents("php://input"), true);

// Verifica se os campos necessários foram enviados
if (!isset($data["file"], $data["dir"], $data["time"])) {
    http_response_code(400);
    echo "Parâmetros ausentes.";
    exit;
}

// Escapa os valores para evitar injeção de comandos
$file = escapeshellarg($data["file"]);
$dir = escapeshellarg($data["dir"]);
$time = escapeshellarg($data["time"]);

// Caminho completo para o script Python
$script = "/home/pi/Documents/web_DWM1001_log.py";  // ajuste se estiver em outro lugar

// Monta o comando completo
$cmd = "setsid python3 $script --file $file --dir $dir --time $time > /dev/null 2>&1 &";

// Executa o comando em segundo plano
exec($cmd);

// Resposta para o navegador
echo "✅ Coleta iniciada com sucesso!";
?>

