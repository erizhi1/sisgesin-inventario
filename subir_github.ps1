# Script para subir el proyecto a GitHub
# Reemplaza TU_USUARIO y TU_REPOSITORIO con tus datos reales

Write-Host "🚀 SUBIENDO SISGESIN A GITHUB" -ForegroundColor Cyan
Write-Host "=============================" -ForegroundColor Cyan

Write-Host ""
Write-Host "📋 PASOS PARA SUBIR A GITHUB:" -ForegroundColor Yellow
Write-Host "1. Crea un nuevo repositorio en GitHub.com" -ForegroundColor White
Write-Host "2. Copia la URL del repositorio que creaste" -ForegroundColor White
Write-Host "3. Ejecuta los comandos de abajo reemplazando TU_USUARIO/TU_REPOSITORIO" -ForegroundColor White

Write-Host ""
Write-Host "🔧 COMANDOS A EJECUTAR:" -ForegroundColor Yellow
Write-Host "======================" -ForegroundColor Yellow

Write-Host "# Eliminar el remote origin actual (Laravel)" -ForegroundColor Green
Write-Host "git remote remove origin" -ForegroundColor Gray

Write-Host ""
Write-Host "# Agregar tu repositorio como origin" -ForegroundColor Green
Write-Host "git remote add origin https://github.com/TU_USUARIO/TU_REPOSITORIO.git" -ForegroundColor Gray

Write-Host ""
Write-Host "# Crear una nueva rama main y subir" -ForegroundColor Green
Write-Host "git checkout -b main" -ForegroundColor Gray
Write-Host "git push -u origin main" -ForegroundColor Gray

Write-Host ""
Write-Host "💡 EJEMPLO:" -ForegroundColor Yellow
Write-Host "git remote add origin https://github.com/erich/sisgesin-inventario.git" -ForegroundColor Gray

Write-Host ""
Write-Host "🎯 Una vez que tengas la URL de tu repositorio, dímela y te ayudo a ejecutar los comandos!" -ForegroundColor Green
