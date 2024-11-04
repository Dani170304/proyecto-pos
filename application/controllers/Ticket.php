<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('file');
        // Add CORS headers for AJAX requests
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');
        
        // Handle preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit(0);
        }
    }
    
    public function save_bill() {
        try {
            // Verify POST request
            if ($this->input->method() != 'post') {
                throw new Exception('Método no permitido');
            }
    
            // Get and validate JSON data
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
    
            if ($data === null) {
                throw new Exception('JSON inválido');
            }
    
            // Validate required fields
            if (!isset($data['cart']) || !isset($data['name']) || !isset($data['id'])) {
                throw new Exception('Datos incompletos');
            }
    
            // Create bills directory if it doesn't exist
            $directory = FCPATH . 'facturas';
            if (!file_exists($directory)) {
                if (!mkdir($directory, 0777, true)) {
                    throw new Exception('No se pudo crear el directorio de facturas');
                }
                chmod($directory, 0777);  // Asegurar permisos del directorio
            }
    
            // Generate bill content
            $contenido = $this->generate_bill_content($data);
    
            // Save the file
            $filename = 'factura_' . $data['newIdOrden'] . '.txt';
            $filepath = $directory . DIRECTORY_SEPARATOR . $filename;
    
            if (!write_file($filepath, $contenido)) {
                throw new Exception('Error al guardar el archivo');
            }
            
            // Establecer permisos del archivo
            chmod($filepath, 0777);
    
            // Return success response
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => 'Factura guardada correctamente',
                    'filename' => $filename
                ]));
    
        } catch (Exception $e) {
            // Log the error for debugging
            log_message('error', 'Error en save_bill: ' . $e->getMessage());
            
            // Return error response
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]));
        }
    }
    public function save_bill_2() {
        try {
            // Verify POST request
            if ($this->input->method() != 'post') {
                throw new Exception('Método no permitido');
            }
    
            // Get and validate JSON data
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
    
            if ($data === null) {
                throw new Exception('JSON inválido');
            }
    
            // Validate required fields
            if (!isset($data['cart']) || !isset($data['name']) || !isset($data['id'])) {
                throw new Exception('Datos incompletos');
            }
    
            // Create bills directory if it doesn't exist
            $directory = FCPATH . 'facturas';
            if (!file_exists($directory)) {
                if (!mkdir($directory, 0777, true)) {
                    throw new Exception('No se pudo crear el directorio de facturas');
                }
                chmod($directory, 0777);  // Asegurar permisos del directorio
            }
    
            // Generate bill content
            $contenido = $this->generate_bill_content_2($data);
    
            // Save the file
            $filename = 'factura_copia_' . $data['newIdOrden'] . '.txt';
            $filepath = $directory . DIRECTORY_SEPARATOR . $filename;
    
            if (!write_file($filepath, $contenido)) {
                throw new Exception('Error al guardar el archivo');
            }
            
            // Establecer permisos del archivo
            chmod($filepath, 0777);
    
            // Return success response
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => 'Factura guardada correctamente',
                    'filename' => $filename
                ]));
    
        } catch (Exception $e) {
            // Log the error for debugging
            log_message('error', 'Error en save_bill: ' . $e->getMessage());
            
            // Return error response
            $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'error' => $e->getMessage()
                ]));
        }
    }

    private function generate_bill_content($data) {
        // Códigos de control para la impresora Epson
        $ESC = "\x1B";
        $GS = "\x1D";
        
        // Comandos para configurar la fuente
        $FONT_GILROY = $ESC . "k" . "\x01";
        $FONT_SIZE_9 = $ESC . "!" . "\x02";
        $RESET_FONT = $ESC . "@";
        
        $contenido = $RESET_FONT . $FONT_GILROY . $FONT_SIZE_9;
        
        $lineaContinua = str_repeat("-", 48);
        
        // Header con indentación
        $espaciosInicio = str_repeat(" ", 7);
        $contenido .= $espaciosInicio . $this->center_text("DRINKMASTER", 35) . "\n";
        $contenido .= $espaciosInicio . $this->center_text("Cochabamba - Bolivia", 35) . "\n";
        $contenido .= $espaciosInicio . $this->center_text(date('Y'), 35) . "\n";
        
        // Formatear fecha a dd/mm/yyyy hh:mm
        $fechaFormateada = date('d/m/Y H:i', strtotime($data['fecha_hora']));
        $contenido .= $espaciosInicio . $this->center_text($fechaFormateada, 35) . "\n";
        $contenido .= "$lineaContinua\n";
        
        // User info
        $contenido .= sprintf("Usuario: %38s\n", $data['name']);
        $contenido .= sprintf("Nº de Orden: %33s\n", $data['id']);
        $contenido .= "$lineaContinua\n";
        
        // Table header
        $contenido .= sprintf("%-9s %-16s %9s %11s\n", 
            "Cant.", "Producto", "Precio", "Subtotal");
        // Añadir un espacio después del encabezado
        $contenido .= "\n";
            
        // Products
        $total = 0;
        foreach ($data['cart'] as $item) {
            $subtotal = $item['valor'] * $item['cantidad'];
            $total += $subtotal;
            
            // Dividir el nombre del producto en líneas de máximo 15 caracteres
            $palabras = explode(" ", $item['nombre']);
            $lineas = [];
            $linea_actual = "";
            
            foreach ($palabras as $palabra) {
                if (strlen($linea_actual . " " . $palabra) <= 15) {
                    $linea_actual = trim($linea_actual . " " . $palabra);
                } else {
                    if ($linea_actual !== "") {
                        $lineas[] = $linea_actual;
                    }
                    $linea_actual = $palabra;
                }
            }
            if ($linea_actual !== "") {
                $lineas[] = $linea_actual;
            }
            
            // Imprimir la primera línea con cantidad, precio y subtotal
            $contenido .= sprintf("%-9s %-16s %9.2f %11.2f\n",
                "x" . $item['cantidad'],
                $lineas[0],
                $item['valor'],
                $subtotal
            );
            
            // Imprimir las líneas adicionales del nombre con indentación
            for ($i = 1; $i < count($lineas); $i++) {
                $contenido .= sprintf("%-8s %-15s\n", "", $lineas[$i]);
            }
            
            // Añadir un espacio en blanco después de cada producto
            $contenido .= "\n";
        }
        
        // Footer con total formateado
        $contenido .= "$lineaContinua\n";
        $contenido .= sprintf("Importe TOTAL Bs.: %28.2f\n", $total);
        $contenido .= "$lineaContinua\n";
        
        // Amount in words con formato mejorado
        $entero = floor($total);
        $decimales = round(($total - $entero) * 100);
        $literalEntero = ucfirst($this->numero_a_letras($entero));
        $contenido .= "Son: $literalEntero {$decimales}/100 BOLIVIANOS\n";
        
        // Reset font y corte de papel
        $contenido .= $RESET_FONT;
        $CUT_PAPER = $GS . "V" . "\x41" . "\x00";
        $contenido .= $CUT_PAPER;
        
        return $contenido;
    }
    
    
    private function center_text($text, $width) {
        $pad = max(0, ($width - strlen($text)) / 2);
        return str_repeat(" ", floor($pad)) . $text . str_repeat(" ", ceil($pad));
    }
    
    private function numero_a_letras($numero) {
        $formatter = new NumberFormatter('es', NumberFormatter::SPELLOUT);
        return ucfirst($formatter->format($numero));
    }


    //
    private function generate_bill_content_2($data) {
        // Códigos de control para la impresora Epson
        $ESC = "\x1B";
        $GS = "\x1D";
        
        // Comandos para configurar la fuente
        $FONT_GILROY = $ESC . "k" . "\x01";
        $FONT_SIZE_9 = $ESC . "!" . "\x02";
        $RESET_FONT = $ESC . "@";
        
        $contenido = $RESET_FONT . $FONT_GILROY . $FONT_SIZE_9;
        
        $lineaContinua = str_repeat("-", 48);
        
        // Header con indentación
        $espaciosInicio = str_repeat(" ", 7);
        $contenido .= $espaciosInicio . $this->center_text("DRINKMASTER", 35) . "\n";
        $contenido .= $espaciosInicio . $this->center_text("Cochabamba - Bolivia", 35) . "\n";
        $contenido .= $espaciosInicio . $this->center_text(date('Y'), 35) . "\n";
        
        
        // Formatear fecha a dd/mm/yyyy hh:mm
        $fechaFormateada = date('d/m/Y H:i', strtotime($data['fecha_hora']));
        $contenido .= $espaciosInicio . $this->center_text($fechaFormateada, 35) . "\n";
        $contenido .= $espaciosInicio . $this->center_text("COPIA", 35) . "\n";
        $contenido .= "$lineaContinua\n";
        
        // User info
        $contenido .= sprintf("Usuario: %38s\n", $data['name']);
        $contenido .= sprintf("Nº de Orden: %33s\n", $data['id']);
        $contenido .= "$lineaContinua\n";
        
        // Table header
        $contenido .= sprintf("%-9s %-16s %9s %11s\n", 
            "Cant.", "Producto", "Precio", "Subtotal");
        // Añadir un espacio después del encabezado
        $contenido .= "\n";
            
        // Products
        $total = 0;
        foreach ($data['cart'] as $item) {
            $subtotal = $item['valor'] * $item['cantidad'];
            $total += $subtotal;
            
            // Dividir el nombre del producto en líneas de máximo 15 caracteres
            $palabras = explode(" ", $item['nombre']);
            $lineas = [];
            $linea_actual = "";
            
            foreach ($palabras as $palabra) {
                if (strlen($linea_actual . " " . $palabra) <= 15) {
                    $linea_actual = trim($linea_actual . " " . $palabra);
                } else {
                    if ($linea_actual !== "") {
                        $lineas[] = $linea_actual;
                    }
                    $linea_actual = $palabra;
                }
            }
            if ($linea_actual !== "") {
                $lineas[] = $linea_actual;
            }
            
            // Imprimir la primera línea con cantidad, precio y subtotal
            $contenido .= sprintf("%-9s %-16s %9.2f %11.2f\n",
                "x" . $item['cantidad'],
                $lineas[0],
                $item['valor'],
                $subtotal
            );
            
            // Imprimir las líneas adicionales del nombre con indentación
            for ($i = 1; $i < count($lineas); $i++) {
                $contenido .= sprintf("%-8s %-15s\n", "", $lineas[$i]);
            }
            
            // Añadir un espacio en blanco después de cada producto
            $contenido .= "\n";
        }
        
        // Footer con total formateado
        $contenido .= "$lineaContinua\n";
        $contenido .= sprintf("Importe TOTAL Bs.: %28.2f\n", $total);
        $contenido .= "$lineaContinua\n";
        
        // Amount in words con formato mejorado
        $entero = floor($total);
        $decimales = round(($total - $entero) * 100);
        $literalEntero = ucfirst($this->numero_a_letras($entero));
        $contenido .= "Son: $literalEntero {$decimales}/100 BOLIVIANOS\n";
        
        // Reset font y corte de papel
        $contenido .= $RESET_FONT;
        $CUT_PAPER = $GS . "V" . "\x41" . "\x00";
        $contenido .= $CUT_PAPER;
        
        return $contenido;
    }
    
}