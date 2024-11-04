#!/bin/bash

# Configuración
WATCH_DIR="/opt/lampp/htdocs/POS-SELF/facturas"
PRINTER="EPSON_TM-T20IIIL"
LOG_FILE="/var/log/print_monitor.log"

# Configuración de impresión
FONT_NAME="Gilroy"
FONT_SIZE="9"
PAPER_WIDTH="80mm"
PAPER_HEIGHT="297mm"

# Crear archivo de log si no existe
touch "$LOG_FILE"

# Función para registrar mensajes
log_message() {
    echo "$(date '+%Y-%m-%d %H:%M:%S') - $1" >> "$LOG_FILE"
}

# Función para imprimir archivo con fuente personalizada
print_file() {
    local file="$1"
    if [ -f "$file" ]; then
        log_message "Intentando imprimir: $file con fuente $FONT_NAME tamaño $FONT_SIZE"
        
        # Crear un archivo temporal con configuración específica de fuente
        local temp_file=$(mktemp)
        
        # Configurar opciones de impresión en un archivo PPD temporal
        cat > "$temp_file" << EOF
*PPD-Adobe: "4.3"
*DefaultFont: ${FONT_NAME}-${FONT_SIZE}
*Font ${FONT_NAME}: Standard "(${FONT_SIZE})" Standard ROM
EOF
        
        # Comando de impresión con opciones personalizadas
        lp -d "$PRINTER" \
           -o media="Custom.${PAPER_WIDTH}x${PAPER_HEIGHT}" \
           -o cpi=17 \
           -o lpi=6 \
           -o page-left=0 \
           -o page-right=0 \
           -o page-top=0 \
           -o page-bottom=0 \
           -o fit-to-page \
           -o PPDFile="$temp_file" \
           "$file" 2>> "$LOG_FILE"
        
        local print_status=$?
        
        # Limpiar archivo temporal
        rm -f "$temp_file"
        
        if [ $print_status -eq 0 ]; then
            log_message "Archivo impreso exitosamente: $file"
        else
            log_message "Error al imprimir archivo: $file"
        fi
    else
        log_message "Archivo no encontrado: $file"
    fi
}

# Verificar que el directorio existe
if [ ! -d "$WATCH_DIR" ]; then
    log_message "Error: Directorio $WATCH_DIR no existe"
    exit 1
fi

# Verificar que la impresora existe
if ! lpstat -p "$PRINTER" > /dev/null 2>&1; then
    log_message "Error: Impresora $PRINTER no encontrada"
    exit 1
fi

# Verificar que inotifywait está instalado
if ! command -v inotifywait >/dev/null 2>&1; then
    log_message "Error: inotifywait no está instalado. Por favor, instale inotify-tools"
    exit 1
fi

log_message "Iniciando monitoreo en directorio: $WATCH_DIR"

# Monitorear el directorio
inotifywait -m "$WATCH_DIR" -e create -e moved_to |
    while read -r directory events filename; do
        if [[ "$filename" =~ \.txt$ ]]; then
            log_message "Nuevo archivo detectado: $filename"
            # Esperar un momento para asegurar que el archivo se haya escrito completamente
            sleep 1
            print_file "$WATCH_DIR/$filename"
        fi
    done
